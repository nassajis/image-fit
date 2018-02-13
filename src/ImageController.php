<?php

namespace Nassajis\ImageFit;

use App\Http\Controllers\Controller;
use Image;
use Request;

class ImageController extends Controller
{
    public function create($image, $type, $width, $height, $ext)
    {
        try {
            if ((config('app.debug') || !empty(Request::server('HTTP_REFERER')))) {
                $w = $width * 10;
                if ($w <= 0) $w = null;

                $h = $height * 10;
                if ($h <= 0) $h = null;

                if ($w > 20000 || $h > 15000)
                    if (($image404 = config('image-fit.image_404')) && file_exists(public_path($image404))) {
                        $img = Image::make($image404);
                    } elseif (file_exists(public_path('vendor/image-fit/404.jpg'))) {
                        $img = Image::make(public_path('vendor/image-fit/404.jpg'));
                    } else
                        die('Please Publish Command : php artisan vendor:publish --provider="Nassajis\ImageFit\ImageFitServiceProvider"');

                if (!in_array($type, ['_', '-']))
                    if (($image404 = config('image-fit.image_404')) && file_exists(public_path($image404))) {
                        $img = Image::make($image404);
                    } elseif (file_exists(public_path('vendor/image-fit/404.jpg'))) {
                        $img = Image::make(public_path('vendor/image-fit/404.jpg'));
                    } else
                        die('Please Publish Command : php artisan vendor:publish --provider="Nassajis\ImageFit\ImageFitServiceProvider"');

                if (file_exists(public_path("files{$image}.{$ext}")))
                    $img = Image::make("files{$image}.{$ext}");
                else {
                    if (($image404 = config('image-fit.image_404')) && file_exists(public_path($image404))) {
                        $img = Image::make($image404);
                    } elseif (file_exists(public_path('vendor/image-fit/404.jpg'))) {
                        $img = Image::make(public_path('vendor/image-fit/404.jpg'));
                    } else
                        die('Please Publish Command : php artisan vendor:publish --provider="Nassajis\ImageFit\ImageFitServiceProvider"');
                }

                switch ($type) {
                    case '_':
                        if ($w == null || $h == null)
                            die('Please Publish Command : php artisan vendor:publish --provider="Nassajis\ImageFit\ImageFitServiceProvider"');
                        else {
                            $img->fit($w, $h);
                        }
                        break;
                    case '-':
                        if ($w != null && $h == null)
                            $img->widen($w);
                        elseif ($w == null && $h != null)
                            $img->heighten($h);
                        elseif ($w != null && $h != null) {
                            $img->resize($w, $h, function ($constraint) {
                                $constraint->aspectRatio();
                                #$constraint->upsize();
                            });
                        }

                        break;
                }

                @mkdir(dirname(public_path(config('image-fit.prefix') . "{$image}.{$ext}")), 0755, true);
                $img->save(public_path(config('image-fit.prefix') . "{$image}{$type}{$width}x{$height}.{$ext}"));
                return $img->response($ext);
            }
        } catch (\Exception $e) {
        }

        die('Please Publish Command : php artisan vendor:publish --provider="Nassajis\ImageFit\ImageFitServiceProvider"');
    }
}
