<?php

/*
 * This file is part of the pngoptmzr package.
 *
 * (c) Renan Galeno <g@renan.eng.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace pngoptmzr;

class pngoptmzr
{
	/* Optimizes PNG file from a path
	 * @param $imagepath string - path to any PNG file, e.g. $_FILE['file']['tmp_name']
	 * @param $max_quality int - conversion quality, useful values from 60 to 100 (smaller number = smaller file)
	 * @param $min_quality int - guarantee that quality won't be worse than that
	 * @return string - content of PNG file after conversion
	*/
	public static function fromFile($imagepath, $max_quality = 80, $min_quality = 60)
	{
		// PNGQuant
		shell_exec("pngquant --quality=$min_quality-$max_quality -- ".escapeshellarg($imagepath));
		// OptiPNG
		shell_exec("optipng ".escapeshellarg($imagepath));
		// PNGCrush
		shell_exec("pngcrush -ow ".escapeshellarg($imagepath));

		//Read from file
		$compressed_png_content = file_get_contents($imagepath);
	    // Return the string containing minified png
	    return $compressed_png_content;
	}

	/* Optimizes PNG file from a string
	 * @param $string string - contents of the PNG file
	 * @param $max_quality int - conversion quality, useful values from 60 to 100 (smaller number = smaller file)
	 * @param $min_quality int - guarantee that quality won't be worse than that
	 * @return string - content of PNG file after conversion
	*/
	public static function fromString($string, $max_quality = 90, $min_quality = 60)
	{
		// Save the string in disk
		$filename = "tmp".md5(uniqid(rand(), true)).".png";
		file_put_contents($filename, $string);
		$compressed_png_content = pngoptmzr::fromFile($filename, $max_quality, $min_quality);
		unlink($filename);
	    // Return the string containing minified png
	    return $compressed_png_content;
	}
}
?>