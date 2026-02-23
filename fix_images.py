import os
import shutil

img_dir = "images/tuevent"

if not os.path.exists(img_dir):
    print(f"Directory {img_dir} does not exist.")
    exit(1)

for filename in os.listdir(img_dir):
    if "-1920w" in filename:
        target_name = filename.replace("-1920w", "-2880w")
        src_path = os.path.join(img_dir, filename)
        dst_path = os.path.join(img_dir, target_name)
        
        if not os.path.exists(dst_path):
            try:
                shutil.copy2(src_path, dst_path)
                print(f"Created {target_name} from {filename}")
            except Exception as e:
                print(f"Error copying {filename}: {e}")
        else:
            # print(f"Exists: {target_name}")
            pass

print("Image fix complete.")
