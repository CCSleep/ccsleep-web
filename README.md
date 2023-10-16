# ccsleep.net source code
Source code for https://ccsleep.net/

Cosplay site. Poorly thrown together, but it works.

Original purpose is to create web gallery that can upload images via filesystems, and a 'usable' CMS.

Working on a rewrite because it's getting messy (especially the upload API).

## Features
- Blog
- Admin Panel
- Events Tables and Galleries Posts
- Image Gallery (w/ upload via filesystem, tagging people)
- Cosplayers (well it's a cosplay site)
- Markdown support via [Parsedown](https://github.com/erusev/parsedown)
- Actually very easy to style, mostly classless

## Deploying

Tested with PHP 7.3 and 8.0 (Apache only)

Requirements
- Any S3 instance (in production, my web use Cloudflare R2)
- PHP web server (Apache only!)

1. Supply aws.phar from https://docs.aws.amazon.com/aws-sdk-php/v3/download/aws.phar and put it in `common/` folder
2. Edit `common/s3_credentials.php` to your own S3 credentials (the config is ready for Cloudflare R2)
3. Edit `common/conn.php` to your database credentials
4. Edit admin password on `page/admin_login.php` (default is `admin`, you should probably change it)
5. Drag and drop this repo to your web server, and enjoy!

_To access admin panel, access /admin on your web_
_To upload image folders, please see content/README.md_

# License
MIT
