<?php

namespace Modules\LogManager\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the path to the logs directory
        $logsPath = storage_path('logs');

        // Get all directories in the logs folder
        $logFolders = File::directories($logsPath);

        // Prepare folder names
        $folderNames = collect($logFolders)
            ->map(function ($path) {
                return basename($path);
            })
            ->toArray();

        // Add root log files
        $rootLogFiles = File::files($logsPath);
        $rootLogFileNames = collect($rootLogFiles)
            ->filter(function ($file) {
                return strpos($file->getFilename(), 'laravel-') === 0;
            })
            ->map(function ($file) {
                return $file->getFilename();
            })
            ->toArray();

        return view('logmanager::index',[
            'logFolders' => $folderNames,
            'rootLogFiles' => $rootLogFileNames
        ]);
    }


    /**
     * Display log files in a specific folder
     */
    public function showFolder($folderName)
    {
        // Validate folder name to prevent directory traversal
        $folderName = basename($folderName);

        // Get the path to the specific log folder
        $folderPath = storage_path('logs/' . $folderName);

        // Check if folder exists
        if (!File::exists($folderPath)) {
            abort(404, 'Folder not found');
        }

        // Get log files in the folder
        $logFiles = File::files($folderPath);

        // Prepare file details
        $fileDetails = collect($logFiles)
            ->map(function ($file) {
                $arr = [
                    'name' => $file->getFilename(),
                    'size' => $file->getSize(),
                    'last_modified' => $file->getMTime()
                ];

                return $arr;
            })
            ->sortByDesc('last_modified')
            ->values()
            ->all();

        return view('logmanager::folder', [
            'folderName' => $folderName,
            'logFiles' => $fileDetails
        ]);
    }

    /**
     * Display contents of a specific log file
     */
    public function showFile(Request $request, $folderName, $fileName)
    {
        // Validate folder and file names to prevent directory traversal
        $folderName = basename($folderName);
        $fileName = basename($fileName);

        // Determine file path
        $filePath = $folderName === 'root'
            ? storage_path('logs/' . $fileName)
            : storage_path('logs/' . $folderName . '/' . $fileName);

        // Check if file exists
        if (!File::exists($filePath)) {
            abort(404, 'Log file not found');
        }

        // Read file contents
        $fileContents = File::get($filePath);

        // Split contents into lines and reverse (newest first)
        $lines = array_reverse(explode("\n", $fileContents));

        // Remove empty lines
        $lines = array_filter($lines);

        // Search functionality
        $searchTerm = $request->get('search');
        $matchedLines = [];
        $unmatchedLines = [];

        if (!empty($searchTerm)) {
            foreach ($lines as $line) {
                // Case-insensitive search across the entire line
                if (stripos($line, $searchTerm) !== false) {
                    $matchedLines[] = $line;
                } else {
                    $unmatchedLines[] = $line;
                }
            }

            $matchedCount = count($matchedLines);
        } else {
            $unmatchedLines = $lines;
            $matchedCount = 0;
        }

        // Combine matched and unmatched lines
        $filteredLines = array_merge($matchedLines, $unmatchedLines);

        // Paginate the lines
        $page = $request->get('page', 1);
        $perPage = 20; // Number of log entries per page

        $paginatedLines = new LengthAwarePaginator(
            array_slice($filteredLines, ($page - 1) * $perPage, $perPage),
            count($filteredLines),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('logmanager::file', [
            'folderName' => $folderName,
            'fileName' => $fileName,
            'fileContents' => $paginatedLines,
            'searchTerm' => $searchTerm,
            'matchedCount' => $matchedCount
        ]);
    }
}
