<?php

/*
 * This file is part of the pngoptmzr package.
 * Based on original code by pngquant: https://pngquant.org/php.html
 *
 * (c) Renan Galeno <g@renan.eng.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace pngoptmzr;

class pngoptmzr
{
	/* Check if png quant is installed
	 * @return boolean - true if pngquant is installed, false if it isn't
	*/
	public function isOk()
	{
		// Check if pngquant is installed
		$sh = shell_exec("which pngquant");
		// Return true or false
	    return (empty($sh) ? false : true);
	}
	/* Optimizes PNG file with pngquant from a path
	 * @param $imagepath string - path to any PNG file, e.g. $_FILE['file']['tmp_name']
	 * @param $max_quality int - conversion quality, useful values from 60 to 100 (smaller number = smaller file)
	 * @param $min_quality int - guarantee that quality won't be worse than that
	 * @return string - content of PNG file after conversion
	*/
	public function fromFile($imagepath, $max_quality = 90, $min_quality = 60)
	{
		// Shell exec pngquant getting return as string
		$compressed_png_content = shell_exec("pngquant --quality=$min_quality-$max_quality - < ".escapeshellarg($imagepath));
		// Check if we have success, or trow exception
	    if (!$compressed_png_content) {
	        throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
	    }
	    // Return the string containing minified png
	    return $compressed_png_content;
	}
	/* Optimizes PNG file with pngquant from a string
	 * @param $image string - image itself as string
	 * @param $max_quality int - conversion quality, useful values from 60 to 100 (smaller number = smaller file)
	 * @param $min_quality int - guarantee that quality won't be worse than that
	 * @return string - content of PNG file after conversion
	*/
	public function fromString($image, $max_quality = 90, $min_quality = 60)
	{
		// Shell exec pngquant getting return as string
		$compressed_png_content = shell_exec("pngquant --quality=$min_quality-$max_quality - ".escapeshellarg($image));
		// Check if we have success, or trow exception
	    if (!$compressed_png_content) {
	        throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
	    }
	    // Return the string containing minified png
	    return $compressed_png_content;
	}
}
?>