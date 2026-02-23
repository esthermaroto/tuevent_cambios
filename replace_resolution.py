try:
    with open("tuevent.html", "r", encoding="utf-8") as f:
        content = f.read()

    new_content = content.replace("-2880w", "-1920w")

    with open("tuevent.html", "w", encoding="utf-8") as f:
        f.write(new_content)
    
    print("Replaced 2880w with 1920w successfully.")

except Exception as e:
    print(f"Error: {e}")
