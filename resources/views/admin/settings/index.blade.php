@extends('admin.layouts.app')

@section('title', 'Global Settings')
@section('page_title', 'Configuration')

@section('content')
<div class="max-w-4xl" x-data="{ tab: 'general' }">
    <!-- Tabs Nav -->
    <div class="flex border-b border-black/5 mb-8 overflow-x-auto">
        <button @click="tab = 'general'" :class="{'border-luxury-black text-luxury-black font-semibold': tab === 'general'}" class="px-6 py-4 text-[10px] uppercase tracking-widest opacity-60 hover:opacity-100 border-b-2 border-transparent transition-all whitespace-nowrap">General</button>
        <button @click="tab = 'contact'" :class="{'border-luxury-black text-luxury-black font-semibold': tab === 'contact'}" class="px-6 py-4 text-[10px] uppercase tracking-widest opacity-60 hover:opacity-100 border-b-2 border-transparent transition-all whitespace-nowrap">Contact</button>
        <button @click="tab = 'social'" :class="{'border-luxury-black text-luxury-black font-semibold': tab === 'social'}" class="px-6 py-4 text-[10px] uppercase tracking-widest opacity-60 hover:opacity-100 border-b-2 border-transparent transition-all whitespace-nowrap">Social Media</button>
        <button @click="tab = 'navigation'" :class="{'border-luxury-black text-luxury-black font-semibold': tab === 'navigation'}" class="px-6 py-4 text-[10px] uppercase tracking-widest opacity-60 hover:opacity-100 border-b-2 border-transparent transition-all whitespace-nowrap">Navigation</button>
        <button @click="tab = 'footer'" :class="{'border-luxury-black text-luxury-black font-semibold': tab === 'footer'}" class="px-6 py-4 text-[10px] uppercase tracking-widest opacity-60 hover:opacity-100 border-b-2 border-transparent transition-all whitespace-nowrap">Footer</button>
        <button @click="tab = 'tax'" :class="{'border-luxury-black text-luxury-black font-semibold': tab === 'tax'}" class="px-6 py-4 text-[10px] uppercase tracking-widest opacity-60 hover:opacity-100 border-b-2 border-transparent transition-all whitespace-nowrap">Tax</button>
        <button @click="tab = 'announcement'" :class="{'border-luxury-black text-luxury-black font-semibold': tab === 'announcement'}" class="px-6 py-4 text-[10px] uppercase tracking-widest opacity-60 hover:opacity-100 border-b-2 border-transparent transition-all whitespace-nowrap">Announcement Bar</button>
    </div>

    @if(session('success'))
    <div class="mb-8 p-4 bg-green-50 text-green-700 text-xs flex items-center">
        <i class="ri-checkbox-circle-line mr-2 text-lg"></i> {{ session('success') }}
    </div>
    @endif

    <div class="bg-white border border-black/5 p-10">

        <!-- General Tab -->
        <div x-show="tab === 'general'" x-cloak>
            <h3 class="font-serif text-xl mb-8 border-b border-black/5 pb-4">General Configuration</h3>
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="update_general" value="1">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Site Name</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'L\'ESSENCE' }}" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Site Description</label>
                    <textarea name="site_description" rows="3" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">{{ $settings['site_description'] ?? '' }}</textarea>
                </div>
                <button type="submit" class="mt-4 py-4 px-8 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">Save Changes</button>
            </form>
        </div>

        <!-- Contact Tab -->
        <div x-show="tab === 'contact'" x-cloak>
            <h3 class="font-serif text-xl mb-8 border-b border-black/5 pb-4">Contact Information</h3>
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="update_contact" value="1">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Email Address</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Phone Number</label>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Office Address</label>
                    <textarea name="contact_address" rows="2" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">{{ $settings['contact_address'] ?? '' }}</textarea>
                </div>
                <button type="submit" class="mt-4 py-4 px-8 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">Save Changes</button>
            </form>
        </div>

        <!-- Social Tab -->
        <div x-show="tab === 'social'" x-cloak>
            <h3 class="font-serif text-xl mb-8 border-b border-black/5 pb-4">Social Media Links</h3>
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="update_social" value="1">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Facebook URL</label>
                    <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Instagram URL</label>
                    <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Twitter / X URL</label>
                    <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Pinterest URL</label>
                    <input type="url" name="social_pinterest" value="{{ $settings['social_pinterest'] ?? '' }}" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                </div>
                <button type="submit" class="mt-4 py-4 px-8 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">Save Changes</button>
            </form>
        </div>

        <!-- Navigation Tab -->
        <div x-show="tab === 'navigation'" x-cloak x-data="{
            menuItems: {{ $settings['nav_menu_json'] ?? '[]' }},
            addParent() {
                this.menuItems.push({ label: '', url: '', children: [] });
            },
            addChild(parentIndex) {
                 if (!this.menuItems[parentIndex]) return; // Safety
                if (!this.menuItems[parentIndex].children) {
                    this.menuItems[parentIndex].children = [];
                }
                this.menuItems[parentIndex].children.push({ label: '', url: '' });
            },
            removeParent(index) {
                this.menuItems.splice(index, 1);
            },
            removeChild(parentIndex, childIndex) {
                this.menuItems[parentIndex].children.splice(childIndex, 1);
            },
            moveUp(index) {
                if(index > 0) {
                    const item = this.menuItems[index];
                    this.menuItems.splice(index, 1);
                    this.menuItems.splice(index - 1, 0, item);
                }
            },
            moveDown(index) {
                if(index < this.menuItems.length - 1) {
                    const item = this.menuItems[index];
                    this.menuItems.splice(index, 1);
                    this.menuItems.splice(index + 1, 0, item);
                }
            }
        }">
            <h3 class="font-serif text-xl mb-8 border-b border-black/5 pb-4">Custom Navigation Links</h3>
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="update_nav" value="1">
                <!-- Hidden input to store the JSON string -->
                <input type="hidden" name="nav_menu_json" :value="JSON.stringify(menuItems)">
                
                <div class="space-y-6">
                    <template x-for="(item, index) in menuItems" :key="index">
                        <div class="border border-black/10 bg-gray-50/50 p-4 rounded-sm animate-in fade-in slide-in-from-left-2 duration-300">
                            <!-- Parent Row -->
                            <div class="flex gap-4 items-center">
                                <div class="flex flex-col gap-1 text-black/20">
                                    <button type="button" @click="moveUp(index)" class="hover:text-black hover:bg-black/5 rounded"><i class="ri-arrow-up-s-line"></i></button>
                                    <button type="button" @click="moveDown(index)" class="hover:text-black hover:bg-black/5 rounded"><i class="ri-arrow-down-s-line"></i></button>
                                </div>
                                <div class="flex-1 space-y-2">
                                    <div class="flex gap-4">
                                        <input type="text" x-model="item.label" placeholder="Menu Label" class="flex-1 py-2 px-3 border border-black/10 focus:border-luxury-black outline-none bg-white text-sm">
                                        <input type="text" x-model="item.url" placeholder="URL (e.g. /shop)" class="flex-1 py-2 px-3 border border-black/10 focus:border-luxury-black outline-none bg-white text-sm">
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                     <button type="button" @click="addChild(index)" class="px-3 py-2 bg-white border border-black/10 text-xs uppercase tracking-widest hover:bg-black hover:text-white transition-colors" title="Add Sub Item">
                                        <i class="ri-add-line"></i> Sub Item
                                    </button>
                                    <button type="button" @click="removeParent(index)" class="text-red-400 hover:text-red-600 p-2"><i class="ri-delete-bin-line"></i></button>
                                </div>
                            </div>

                            <!-- Children -->
                            <div class="ml-12 mt-4 space-y-3 pl-4 border-l-2 border-black/5" x-show="item.children && item.children.length > 0">
                                <template x-for="(child, cIndex) in item.children" :key="cIndex">
                                    <div class="flex gap-4 items-center animate-in fade-in slide-in-from-top-1">
                                        <i class="ri-corner-down-right-line text-black/20"></i>
                                        <input type="text" x-model="child.label" placeholder="Sub Item Label" class="flex-1 py-2 px-3 border border-black/10 focus:border-luxury-black outline-none bg-white text-xs">
                                        <input type="text" x-model="child.url" placeholder="Sub Item URL" class="flex-1 py-2 px-3 border border-black/10 focus:border-luxury-black outline-none bg-white text-xs">
                                        <button type="button" @click="removeChild(index, cIndex)" class="text-red-400 hover:text-red-600 p-1"><i class="ri-close-circle-line"></i></button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="pt-4">
                     <button type="button" @click="addParent()" class="py-3 px-6 border border-dashed border-black/20 text-xs uppercase tracking-widest text-black/60 hover:text-black hover:border-black w-full transition-all flex items-center justify-center gap-2">
                        <i class="ri-add-circle-line text-lg"></i> Add Main Menu Item
                    </button>
                </div>

                <button type="submit" class="mt-8 py-4 px-8 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">Save Navigation</button>
            </form>
        </div>

        <!-- Footer Tab -->
        <div x-show="tab === 'footer'" x-cloak>
            <h3 class="font-serif text-xl mb-8 border-b border-black/5 pb-4">Footer Configuration</h3>
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="update_footer" value="1">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Copyright Text</label>
                    <input type="text" name="footer_copyright" value="{{ $settings['footer_copyright'] ?? '© 2026 L\'ESSENCE NYC. All rights reserved.' }}" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                </div>
                <button type="submit" class="mt-4 py-4 px-8 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">Save Changes</button>
            </form>
        </div>

        <!-- Tax Tab -->
        <div x-show="tab === 'tax'" x-cloak>
            <h3 class="font-serif text-xl mb-8 border-b border-black/5 pb-4">Tax Configuration</h3>
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="update_tax_settings" value="1">
                @php $taxEnabled = \App\Models\Setting::get('tax_enabled', false); @endphp
                
                <div class="flex items-center justify-between p-4 bg-gray-50 border border-black/5">
                    <div>
                        <h4 class="text-sm font-semibold mb-1">Enable Tax Calculation</h4>
                        <p class="text-[10px] opacity-60">If disabled, no tax will be applied during checkout.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="tax_enabled" value="1" class="sr-only peer" {{ $taxEnabled ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-luxury-black"></div>
                    </label>
                </div>
                <button type="submit" class="py-4 px-8 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">Save Settings</button>
            </form>
        </div>

        <!-- Announcement Tab -->
        <div x-show="tab === 'announcement'" x-cloak>
            <h3 class="font-serif text-xl mb-8 border-b border-black/5 pb-4">Announcement Bar Configuration</h3>
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="update_announcement_bar" value="1">
                
                <div class="flex items-center justify-between p-4 bg-gray-50 border border-black/5">
                    <div>
                        <h4 class="text-sm font-semibold mb-1">Show Announcement Bar</h4>
                        <p class="text-[10px] opacity-60">Toggle the visibility of the top bar on the website.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="topbar_visible" value="1" class="sr-only peer" {{ \App\Models\Setting::get('topbar_visible', false) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-luxury-black"></div>
                    </label>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Background Color</label>
                        <div class="flex items-center gap-4">
                            <input type="color" name="topbar_bg" value="{{ $settings['topbar_bg'] ?? '#D4AF37' }}" class="w-12 h-12 border-none bg-transparent cursor-pointer">
                            <input type="text" value="{{ $settings['topbar_bg'] ?? '#D4AF37' }}" class="flex-1 py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm font-mono" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Text Color</label>
                        <div class="flex items-center gap-4">
                            <input type="color" name="topbar_text_color" value="{{ $settings['topbar_text_color'] ?? '#000000' }}" class="w-12 h-12 border-none bg-transparent cursor-pointer">
                            <input type="text" value="{{ $settings['topbar_text_color'] ?? '#000000' }}" class="flex-1 py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm font-mono" readonly>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-black/5">
                     <a href="{{ route('admin.announcements.index') }}" class="text-[10px] uppercase tracking-widest text-luxury-accent hover:underline flex items-center gap-2">
                         <i class="ri-edit-line"></i> Manage Announcements List
                     </a>
                </div>

                <button type="submit" class="py-4 px-8 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all shadow-lg">Save Announcement Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    document.getElementById('add-nav-row').addEventListener('click', function() {
        const container = document.getElementById('nav-container');
        const row = document.createElement('div');
        row.className = 'flex gap-4 items-center nav-row animate-in fade-in slide-in-from-left-2 duration-300';
        row.innerHTML = `
            <div class="flex-1">
                <input type="text" name="nav_label[]" placeholder="Label" class="w-full py-2 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
            </div>
            <div class="flex-1">
                <input type="text" name="nav_url[]" placeholder="URL" class="w-full py-2 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
            </div>
            <button type="button" class="text-red-400 hover:text-red-600 remove-row"><i class="ri-delete-bin-line"></i></button>
        `;
        container.appendChild(row);
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('.nav-row').remove();
        }
    });
</script>
@endsection
