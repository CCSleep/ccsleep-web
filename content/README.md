# Content Folder

The web will read this directory in order to process folders. Normally, I set up FTP here.

The web will read ZIP archives and folders, as well as images in JPG, PNG and WEBP format.

On folder process, it will:
1. Automatically create thumbnails for each image (in .WEBP)
2. Assign image config according to filenames.
3. Upload folders and thumbnails to your S3 instances.

## ZIP Upload 

1. Create ZIP file containing images
2. Upload ZIP file to FTP server using `content/` folder (ftp.ccsleep.net)
3. The file will appear on the table
4. Choose either `[ExAdd]` (Extract + Process ZIP files) or `[OnlyEx]` (Extract Only)
5. Your folder will appear under "Process Folder" section

## Upload

1. Under GalleryPlus section, choose 'Add GalleryPlus Gallery' and create new gallery.
2. After that, go back to the Admin Panel, then choose 'Upload Image'
3. Under "Process Folder" section, choose the folder you want to process, and write the short name (specified when creating gallery).
4. Press "Submit" under the "Process Folder" section.
