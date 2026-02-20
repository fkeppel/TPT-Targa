<?php
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class LidlImportController extends \BaseController {
    private $XMLPath;
    public function __construct()
    {
        $this->XMLPath = public_path("data/import/XML");
    }
    public function uploadZip(Request $request)
    {
        $file = $request->file('zipfile');
        if (!$file || !$file->isValid()) {
            return response()->json(['error' => 'Ungültige Datei'], 400);
        }
        try {
            $result = $this->uploadAndUnpackZip($file);
            if ($result === false) {
                return response()->json(['error' => 'Fehler beim Verarbeiten der ZIP-Datei'], 500);
            }
            return response()->json(['success' => true, 'files' => $result]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    private function uploadAndUnpackZip($file)
    {
        $destinationPath = public_path("data/import/XML/Zip");
        if (!is_dir($destinationPath) && !mkdir($destinationPath, 0775, true)) {
            throw new \RuntimeException("Kann Ordner nicht erstellen: $destinationPath");
        }
        $filename = Str::random(6) . "_" . $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        $zip = new \ZipArchive();
        if ($zip->open($destinationPath . "/" . $filename) !== true) {
            return false;
        }
        $zipPath = $destinationPath . "/" . pathinfo($filename, PATHINFO_FILENAME);
        if (!is_dir($zipPath) && !mkdir($zipPath, 0775, true)) {
            $zip->close();
            throw new \RuntimeException("Kann Ordner nicht erstellen: $zipPath");
        }
        $zip->extractTo($zipPath);
        $zip->close();
        $unpackedFiles = [
            'infos' => [],
            'xml' => null,
        ];
        // rekursiv wäre besser, aber ich bleibe nah an deinem Ansatz:
        foreach (new \DirectoryIterator($zipPath) as $entry) {
            if ($entry->isDot()) continue;
            if ($entry->isDir()) {
                foreach (new \DirectoryIterator($entry->getPathname()) as $f) {
                    if ($f->isDot() || $f->isDir()) continue;
                    $ext = strtolower($f->getExtension());
                    if ($ext === 'xml' && $unpackedFiles['xml'] === null) {
                        $unpackedFiles['xml'] = [
                            'path' => $entry->getPathname() . DIRECTORY_SEPARATOR,
                            'filename' => $f->getFilename(),
                        ];
                    } else {
                        $unpackedFiles['infos'][] = [
                            'path' => $entry->getPathname() . DIRECTORY_SEPARATOR,
                            'filename' => $f->getFilename(),
                        ];
                    }
                }
            }
        }
        if ($unpackedFiles['xml'] === null) {
            // keine XML gefunden
            return $unpackedFiles;
        }
        $orgFile = $unpackedFiles['xml']['filename'];
        $newName = Str::random(6) . "_" . $orgFile;
        $from = $unpackedFiles['xml']['path'] . $orgFile;
        $to   = rtrim($this->XMLPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $newName;
        if (!is_dir(dirname($to)) && !mkdir(dirname($to), 0775, true)) {
            throw new \RuntimeException("Kann Zielordner nicht erstellen: " . dirname($to));
        }
        rename($from, $to);
        $unpackedFiles['xml']['filename'] = $newName;
        $unpackedFiles['xml']['path'] = rtrim($this->XMLPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        return $unpackedFiles;
    }
}