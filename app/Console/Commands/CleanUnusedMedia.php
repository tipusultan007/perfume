<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CleanUnusedMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:clean-unused {--force : Actually delete the files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up unused media directories from storage that are not in the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        $validMedia = Media::all()->keyBy('id');
        
        $searchPaths = [
            'featured' => storage_path('app/public/products/featured'),
            'gallery' => storage_path('app/public/products/gallery'),
            'uploads' => storage_path('app/public/uploads'),
            'root' => storage_path('app/public'),
        ];

        $deletedCount = 0;
        $totalSize = 0;
        $dbRecordsDeleted = 0;

        foreach ($searchPaths as $type => $path) {
            if (!File::isDirectory($path)) {
                $this->warn("Path not found: {$path}");
                continue;
            }

            $this->info("Checking path ({$type}): {$path}");
            
            $directories = File::directories($path);
            
            foreach ($directories as $directory) {
                $dirName = basename($directory);
                $isOrphan = false;
                $reason = "";

                // Check if directory name is numeric (Media ID)
                if (is_numeric($dirName)) {
                    $mediaId = (int)$dirName;
                    
                    if (!isset($validMedia[$mediaId])) {
                        $isOrphan = true;
                        $reason = "Not in media table";
                    } else {
                        $media = $validMedia[$mediaId];
                        
                        // Check if misplaced (e.g. gallery item in featured folder)
                        if ($type === 'featured' && $media->collection_name !== 'featured') {
                            $isOrphan = true;
                            $reason = "Misplaced: collection is '{$media->collection_name}'";
                        } elseif ($type === 'gallery' && $media->collection_name !== 'gallery') {
                            $isOrphan = true;
                            $reason = "Misplaced: collection is '{$media->collection_name}'";
                        }
                        
                        // Check if linked model exists
                        if (!$isOrphan && class_exists($media->model_type)) {
                            if (!$media->model_type::where('id', $media->model_id)->exists()) {
                                $isOrphan = true;
                                $reason = "Model {$media->model_type} ID {$media->model_id} missing";
                            }
                        }
                    }

                    if ($isOrphan) {
                        $size = $this->getDirSize($directory);
                        $totalSize += $size;
                        
                        $msg = "Orphan/Unused found: {$directory} ({$reason}, " . $this->formatSize($size) . ")";
                        
                        if ($force) {
                            $this->warn("Deleting: " . $msg);
                            File::deleteDirectory($directory);
                            
                            // If it was in DB but model missing, delete DB record too
                            if (isset($validMedia[$mediaId]) && $reason === "Model missing") {
                                $validMedia[$mediaId]->delete();
                                $dbRecordsDeleted++;
                            }
                            
                            $deletedCount++;
                        } else {
                            $this->line("Would delete: " . $msg);
                            $deletedCount++;
                        }
                    }
                }
            }
        }

        $this->info("Total orphaned directories handled: {$deletedCount}");
        if ($force) {
            $this->info("Database records cleaned: {$dbRecordsDeleted}");
        }
        $this->info("Total space: " . $this->formatSize($totalSize));

        if (!$force && $deletedCount > 0) {
            $this->warn("This was a dry run. Use --force to actually delete the files.");
        }
    }

    /**
     * Get directory size in bytes.
     */
    protected function getDirSize($directory)
    {
        $size = 0;
        foreach (File::allFiles($directory) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }

    /**
     * Format size in human readable format.
     */
    protected function formatSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }
}
