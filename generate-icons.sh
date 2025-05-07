#!/bin/bash

# Check if ImageMagick is installed
if ! command -v convert &> /dev/null
then
    echo "ImageMagick is required but not installed. Please install it first."
    exit 1
fi

# Array of icon sizes needed
SIZES=(72 96 128 144 152 192 384 512)

# Source SVG file
SOURCE="public/icons/icon-template.svg"

# Generate icons for each size
for size in "${SIZES[@]}"
do
    convert -background none -resize ${size}x${size} "$SOURCE" "public/icons/icon-${size}x${size}.png"
    echo "Generated icon-${size}x${size}.png"
done

echo "Icon generation complete!"
