import base64
import os

def create_standalone_svg(png_path, svg_path, width, height):
    if not os.path.exists(png_path):
        print(f"File not found: {png_path}")
        return

    with open(png_path, "rb") as image_file:
        encoded_string = base64.b64encode(image_file.read()).decode('utf-8')

    svg_content = f'''<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 {width} {height}" width="100%" height="100%">
  <image href="data:image/png;base64,{encoded_string}" x="0" y="0" width="{width}" height="{height}" preserveAspectRatio="xMidYMid meet"/>
</svg>'''

    with open(svg_path, "w", encoding="utf-8") as svg_file:
        svg_file.write(svg_content)
    print(f"Created standalone SVG: {svg_path}")

# Paths
base_dir = r'D:\01_Projects\SaraHome-Deploy\public\images'

create_standalone_svg(
    os.path.join(base_dir, 'logo-emblem.png'),
    os.path.join(base_dir, 'logo-emblem.svg'),
    860, 615
)

create_standalone_svg(
    os.path.join(base_dir, 'logo-full.png'),
    os.path.join(base_dir, 'logo-full.svg'),
    1000, 1000
)