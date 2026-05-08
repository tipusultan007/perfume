import os

def replace_in_file(file_path, replacements):
    try:
        with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
        
        modified = False
        for pattern, replacement in replacements:
            if pattern in content:
                content = content.replace(pattern, replacement)
                modified = True
        
        if modified:
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"Updated: {file_path}")
    except Exception as e:
        print(f"Error processing {file_path}: {e}")

def main():
    replacements = [
        ("layouts.shared", "admin.layouts.jidox.shared"),
        ("resources/js/", "resources/jidox/js/"),
        ("resources/scss/", "resources/jidox/scss/"),
        ("resources/css/", "resources/jidox/css/")
    ]
    
    target_dir = 'resources/views/admin/layouts/jidox'
    
    for root, dirs, files in os.walk(target_dir):
        for file in files:
            if file.endswith('.blade.php'):
                replace_in_file(os.path.join(root, file), replacements)

if __name__ == "__main__":
    main()
