<?php

namespace App\Http\Controllers;

use App\Http\repository\BaseExercitoRepository;
use App\Logger;
use App\Models\BaseExercito;
use App\Models\BaseExercitoEmp;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public BaseExercitoRepository $baseExercitoRepository;
    public Logger $logger;

    public function __construct(BaseExercitoRepository $baseExercitoRepository)
    {
        $this->baseExercitoRepository = $baseExercitoRepository;
        $this->logger = new Logger(null, 'UploadController');
    }

    public function upload(Request $request)
    {
        // return phpinfo();
        ini_set(
            'max_execution_time',
            40096
        );
        ini_set('memory_limit', '-1');

        try {
            $file = $request->file('file');
            $fileIsArray = is_array($file);
            $fileIsNotEmpty = !empty($file);
            if (!$fileIsNotEmpty) {
                $this->logger->log_msg('File is empty');
                return response()->json(['errors' => ['Precisa enviar pelo menos 1 arquivo']], 400);
            }
            $results = array();
            if ($fileIsArray) {
                foreach ($file as $key => $value) {
                    if ($value) {
                        $current = $this->make_upload($value);
                        if (!$current[0]) {
                            throw new \Exception($current[1]);
                        }
                        $results[$key] = $current;
                    }
                }
            } else {
                $results = $this->make_upload($file);
            }

            if ($results) {
                // $this->connect_to_access_db($name_file);
                return response()->json(['data' => "Upload realizado com sucesso", 'errors' => []]);
            } else {
                return response()->json(['data' => "Erro ao realizar upload", 'errors' => []]);
            }
        } catch (\Throwable $th) {
            return response()->json(['data' => "Erro ao realizar upload", 'errors' => [$th->getMessage()]], 400);
        }
    }

    public function upload_margem(Request $request)
    {
        try {
            $file = $request->file('file');
            foreach ($file as $key => $value) {
                if ($value) {
                    $current = $this->make_margem_upload($value);
                    if (!$current[0]) {
                        throw new \Exception($current[1]);
                    }
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['data' => "Erro ao realizar upload", 'errors' => [$th->getMessage()]], 400);
        }
    }
    private function make_margem_upload($file)
    {
        $this->logger->log_msg("Starting upload -----------------------");
        $random = rand(1, 1000);
        $fake_name = time() . '_' . $random;
        $ext = $file->getClientOriginalExtension();
        if ($ext != 'csv') {
            throw new \Exception('Arquivo não é um CSV');
        }

        $this->load_excel_margem($file);
    }
    private function load_excel_margem($file_name)
    {

        // $file = file_get_contents($file_name->getRealPath());
        // $csv = explode("\n", $file);
        // $labels = array_shift($csv);
        // $this->logger->log_msg("Labels: " . ($file));
        $row = 1;
        $f = file($file_name->getRealPath());
        $data = [];

        foreach ($f as $line) {
            $data[] = str_getcsv($line);
        }

        if (($handle = fopen($file_name->getRealPath(), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                dd($data);
                $num = count($data);
                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    echo $data[$c] . "<br />\n";
                }
            }
            fclose($handle);
        }
    }
    private function make_upload($file)
    {
        $this->logger->log_msg("Starting upload -----------------------");
        try {
            // BaseExercito::truncate();
            // BaseExercitoEmp::truncate();
            $random = rand(1, 1000);
            $fake_name = time() . '_' . $random;
            $ext = $file->getClientOriginalExtension();
            if ($ext != 'csv') {
                throw new \Exception('Arquivo não é um CSV');
            }
            $file_name = $fake_name . '.' . $ext;
            $result = $file->move(public_path('uploads'),   $file_name);

            $this->load_excel($file_name);
            $this->logger->log_msg("Succesfuly -----------------------");
            $file_name = public_path('uploads') . '/' .  $file_name;
            $this->baseExercitoRepository->deleteFile($file_name);
        } catch (\Throwable $th) {
            $this->logger->log_msg("Error uploading file -----------------------");
            $this->logger->log_msg($th->getMessage());
            return [false, $th->getMessage()];
        }
        // $data = Excel::import(new Application, $file_name);
        $this->logger->close();
        return [!!$result, $file_name];
    }


    private function load_excel($path)
    {
        $path = public_path('uploads/' . $path);

        $paylod = [];

        $lines = file($path, FILE_IGNORE_NEW_LINES);
        $labels = array();
        $items = array();
        foreach ($lines as $key => $value) {
            // $csv[$key] = str_getcsv($value);
            $separated = ';';
            if ($key > 0) {
                $items[$key] = str_getcsv($value, $separated);
            } else {
                $labels = str_getcsv($value,  $separated);
            }
        }
        foreach ($items as $key => $value) {
            // if ($cItems == $cLabels) {
            //     $paylod[$key] = array_combine($labels, $value);
            // }
            foreach ($labels as $k => $label) {

                $paylod[$key][$label] = $value[$k];
            }

            // $paylod[$key] = array_combine($labels, $value);
        }
        $items = array();
        $labels = array();
        $lines = array();
        foreach ($paylod as $key => $value) {
            $this->save_record($value);

            // sleep(1);
        }
        return $paylod;
    }


    private function save_record($record)
    {
        $this->logger->log_msg("Starting upload -----------------------");

        try {

            $this->baseExercitoRepository->save($record);

            $this->logger->log_msg("Succesfuly -----------------------  " . $record['CPF']);
        } catch (\Throwable $th) {
            $this->logger->log_msg("Error uploading file ----------------------- error: " . $th->getMessage());
        }
        $this->logger->close();
    }
}
