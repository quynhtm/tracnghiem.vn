<?php

namespace App\Library\PHPZip;

class Zip {

	protected $lib;				// which library to use
	protected $org_files;       // an array of the files or strings to be zipped
	protected $new_file_path;	// the path to which the zip will be created
	protected $new_file_name;	// file name

	protected $extr_file;		// the file to be extracted
	protected $extr_dirc;		// the target directory which will hold the extarcted files

	public function __construct(){
		$this->lib = 0;
		$this->extr_file = 0;
		$this->new_file_path = 0;
		$this->org_files = array();
	}

	public function zip_start($file_path) {

		$this->new_file_path = $file_path;
		if(class_exists("ZipArchive")) $this->lib = 1;
		else $this->lib = 2;
		return true;
	}

	public function zip_add($in){

		if($this->lib === 0 || $this->new_file_path === 0) throw new \Exception("PHP-ZIP: must call zip_start before zip_add");

		if(is_string($in)){
			if(file_exists($in)) {
				if(!is_dir($in)) array_push($this->org_files,$in);
				else $this->push_whole_dir($in);
			}
		}

		else foreach($in as $value){
			$this->zip_add($value);
		}
		
		return true;
		
	}

	public function zip_end($force_lib = false) {
		if($force_lib === 2) {
			$this->lib = 2;
		}
		elseif ($force_lib === 1) {
			$this->lib = 1;
		}

		if($this->lib === 0 || $this->new_file_path === 0) throw new \Exception('PHP-ZIP: zip_start and zip_add haven\'t been called yet');

		if($this->lib === 1) {
			$names = $this->commonPath($this->org_files, true);
			$lib = new \ZipArchive();
			if(!$lib->open($this->new_file_path,\ZipArchive::CREATE)) throw new \Exception('PHP-ZIP: Permission Denied or zlib can\'t be found');
			
			$count_before = $lib->numFiles;

			foreach ($this->org_files as $index => $org_file_path) {
				// add the file to the archive
				$lib->addFile($org_file_path,$names[$index]);
			}
			
			$count_after = $lib->numFiles;

			$lib->close();
		}

		if($this->lib === 2) {
			$common = $this->commonPath($this->org_files, false);
			if(!$lib = new PclZip($this->new_file_path)) throw new \Exception('PHP-ZIP: Permission Denied or zlib can\'t be found');
			$count_before = count($lib->listContent());
			$lib->add($this->org_files, PCLZIP_OPT_REMOVE_PATH, $common[0]);
			$count_after = count($lib->listContent());
		}
		
		if(!file_exists($this->new_file_path)) throw new \Exception('PHP-ZIP: After doing the zipping file can not be found');
		if(filesize($this->new_file_path) === 0) throw new \Exception('PHP-ZIP: After doing the zipping file size is still 0 bytes');

		$this->org_files = array();
		
		return true;
	}

	public function zip_files($files,$to) {
		
		$this->zip_start($to);
		$this->zip_add($files);
		return $this->zip_end();
		
	}

	public function unzip_file($file_path,$target_dir=NULL) {

		if(!file_exists($file_path)) throw new \Exception("PHP-ZIP: File doesn't Exist");

		$_FILEINFO = finfo_open(FILEINFO_MIME_TYPE);
		$file_mime_type = finfo_file($_FILEINFO, $file_path);
		if(!array_search($file_mime_type,array(
			'application/x-zip',
			'application/zip',
			'application/x-zip-compressed',
			'application/s-compressed',
			'multipart/x-zip')
		)) throw new \Exception("PHP-ZIP: File type is not ZIP");
		
		
		$this->extr_file = $file_path;
		
		if(class_exists("ZipArchive")) $this->lib = 1;
		else $this->lib = 2;
		
		if($target_dir !== NULL) return $this->unzip_to($target_dir);
		else return true;
		
	}

	public function unzip_to($target_dir) {
		if($this->lib === 0 && $this->extr_file === 0) throw new \Exception("PHP-ZIP: unzip_file hasn't been called");
		if(file_exists($target_dir) && (!is_dir($target_dir))) throw new \Exception("PHP-ZIP: Target directory exists as a file not a directory");
		if(!file_exists($target_dir)) if(!mkdir($target_dir)) throw new \Exception("PHP-ZIP: Directory not found, and unable to create it");

		$this->extr_dirc = $target_dir;

		if($this->lib === 1) {
			$lib = new \ZipArchive();
			if(!$lib->open($this->extr_file)) throw new \Exception("PHP-ZIP: Unable to open the zip file");
			if(!$lib->extractTo($this->extr_dirc)) throw new \Exception("PHP-ZIP: Unable to extract files");
			$lib->close();
		} 

		if($this->lib === 2) {
			$lib = new PclZip($this->extr_file);
			if(!$lib->extract(PCLZIP_OPT_PATH,$this->extr_dirc)) throw new \Exception("PHP-ZIP: Unable to extract files");
		}
		
		return true;
		
	}

	private function dir_to_assoc_arr(\DirectoryIterator $dir) {
		$data = array();
		foreach ($dir as $node) {
			if ( $node->isDir() && !$node->isDot() ) {
				$data[$node->getFilename()] = $this->dir_to_assoc_arr(new \DirectoryIterator($node->getPathname()));
			} else if( $node->isFile() ) {
				$data[] = $node->getFilename();
			}
		}
		return $data;
	}

	private function push_whole_dir($dir){
		$dir_array = $this->dir_to_assoc_arr(new \DirectoryIterator($dir));
		foreach($dir_array as $key => $value) {
			if(!is_array($value)) array_push($this->org_files,$this->path($dir,$value));
			else {
				$this->push_whole_dir($this->path($dir,$key));
			}
		}
	}

	private function path() {
		return join(DIRECTORY_SEPARATOR, func_get_args());
	}

	private function commonPath($files, $remove = true) {
		foreach($files as $index => $filesStr) {
			$files[$index] = explode(DIRECTORY_SEPARATOR, $filesStr);
		}
		$toDiff = $files;
		foreach($toDiff as $arr_i => $arr) {
			foreach($arr as $name_i => $name) {
				$toDiff[$arr_i][$name_i] = $name . "___" . $name_i;
			}
		}
		$diff = call_user_func_array("array_diff",$toDiff);
		reset($diff);
		$i = key($diff) - 1;
		if($remove) {
			foreach($files as $index => $arr) {
				$files[$index] = implode(DIRECTORY_SEPARATOR,array_slice($files[$index], $i));
			}
		}
		else {
			foreach($files as $index => $arr) {
				$files[$index] = implode(DIRECTORY_SEPARATOR,array_slice($files[$index], 0, $i));
			}
		}
		return $files;
	}

}