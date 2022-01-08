<?php

/**
 *
 * @param string $dirname absolute path of directory
 * @param boolean $ci_earch Case insensitive search - true to enable
 * @return boolean
 */
function feather_is_dir(&$dirname, $ci_search = true)
{

    if (is_dir($dirname)) {
        return true;
    }

    if (!$ci_search) {
        return false;
    }

    $parentDir = dirname($dirname);

    $dir = preg_replace('/\/|\\\/', '', str_replace($parentDir, '', $dirname));

    $folders = feather_dir_folders($parentDir);

    foreach ($folders as $f) {
        if (strcasecmp($dir, $f) == 0) {
            $dirname = $parentDir . '/' . $f;
            return true;
        }
    }

    return false;
}

/**
 * Check if a file exists
 * @param string $filename absolute path of file to find
 * @param boolean $ci_search Case insensitive search - true to enable
 * @return boolean
 */
function feather_file_exists(&$filename, $ci_search = true)
{

    if (file_exists($filename)) {
        return true;
    }

    if (!$ci_search) {
        return false;
    }

    $parentDir = dirname($filename);

    $file = str_replace($parentDir, '', $filename);

    if (strpos($file, '/') === 0 || strpos($file, '\\') === 0) {
        $file = substr($file, 1);
    }

    $files = feather_dir_files($parentDir);

    foreach ($files as $f) {
        if (strcasecmp($file, $f) == 0) {
            $filename = $parentDir . '/' . $f;
            return true;
        }
    }

    return false;
}

/**
 * Get all files names including files in sub folders
 * @param string $directory Full path of directory
 * @param bool $reduce if true returns as a 1 dimensional array
 * false return a multidimensional array
 * @return array
 */
function feather_dir_all_files(string $directory, bool $reduce = true)
{
    $files = [];

    if (!is_dir($directory)) {
        return $files;
    }

    $dirContents = scandir($directory);
    $dirParts    = preg_split('/\\\|\//', $directory);
    $dirname     = end($dirParts);

    foreach ($dirContents as $file) {

        if ($file == '.' || $file == '..') {
            continue;
        }

        if (is_dir($directory . '/' . $file)) {
            $subFiles = feather_dir_all_files($directory . '/' . $file, $reduce);
            if ($reduce) {
                $files = array_merge($files, $subFiles);
            } else {
                $files[$dirname . '.' . $file] = $subFiles;
            }
        } else {
            $name = substr($file, 0, strrpos($file, '.'));

            if ($reduce) {
                $files[] = $file;
            } else {
                $files[$name] = $file;
            }
        }
    }

    return $files;
}

/**
 *
 * @param string $directory Absolute path of directory
 * @return array List of filenames in the directory
 */
function feather_dir_files($directory)
{

    $files = [];

    if (!is_dir($directory)) {
        return $files;
    }

    $dirContents = scandir($directory);

    if (!$dirContents) {
        return $files;
    }

    foreach ($dirContents as $file) {
        if ($file == '.' || $file == '..' || is_dir($file)) {
            continue;
        }
        $files[] = $file;
    }

    return $files;
}

/**
 *
 * @param string $directory Absolute path of directory
 * @return array List of sub directories names
 */
function feather_dir_folders($directory)
{

    $folders = [];

    if (!is_dir($directory)) {
        return $folders;
    }

    $dirContents = scandir($directory);

    if (!$dirContents) {
        return $folders;
    }

    foreach ($dirContents as $dir) {
        if ($dir == '.' || $dir == '..' || !is_dir($dir)) {
            continue;
        }
        $folders[] = $dir;
    }

    return $folders;
}

/**
 * Get list of directory names including sub directories
 * @param string $directory Absolute path to directory
 * @param bool $reduce if true returns as a 1 dimensional array
 * false return a multidimensional array
 * @return array
 */
function feather_dir_all_folders(string $directory, bool $reduce = true)
{
    $folders = [];

    if (!is_dir($directory)) {
        return $folders;
    }

    $dirContents = scandir($directory);

    if (!$dirContents) {
        return $folders;
    }

    $dirParts = preg_split('/\\\|\//', $directory);
    $dirname  = end($dirParts);

    foreach ($dirContents as $dir) {
        if ($dir == '.' || $dir == '..' || !is_dir($directory . '/' . $dir)) {
            continue;
        }
        if ($reduce) {
            $folders[] = $dir;
        } else {
            $folders[$dirname] = $dir;
        }
        $subFolders = feather_dir_all_folders($directory . '/' . $dir);
        if (!empty($subFolders)) {
            if ($reduce) {
                $folders = array_merge($folders, $subFolders);
            } else {
                $folders[$dir] = $subFolders;
            }
        }
    }

    return $folders;
}
