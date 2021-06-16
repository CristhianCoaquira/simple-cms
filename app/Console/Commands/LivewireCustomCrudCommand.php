<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class LivewireCustomCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire:crud 
    {nameOfTheClass? : The name of the class.}, 
    {nameOfTheModelClass? : The name of the model class.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a custom livewire CRUD';

    /**
     * Custom Variables
     */
    protected $nameOfTheClass;
    protected $nameOfTheModelClass;
    protected $file;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->file = new Filesystem();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Gathers all parameters
        $this->gatherParameters();
        // Generates the livewire Class File
        $this->generateLivewireCrudClassFile();
        // Generates the livewire View File
        $this->generateLivewireCrudViewFile();
    }

    protected function gatherParameters()
    {
        $this->nameOfTheClass = $this->argument('nameOfTheClass');
        $this->nameOfTheModelClass = $this->argument('nameOfTheModelClass');

        if (!$this->nameOfTheClass) {
            $this->nameOfTheClass = $this->ask('Enter class name');
        }
        if (!$this->nameOfTheModelClass) {
            $this->nameOfTheModelClass = $this->ask('Enter model class name');
        }

        // Convert to studly case
        $this->nameOfTheClass = Str::studly($this->nameOfTheClass);
        $this->nameOfTheModelClass = Str::studly($this->nameOfTheModelClass);
    }

    protected function generateLivewireCrudClassFile()
    {
        // Set the origin and destination for the livewire class file
        $fileOrigin = base_path('/stubs/custom.livewire.crud.stub');
        $fileDestination = base_path("/app/Http/Livewire/$this->nameOfTheClass.php");

        if ($this->file->exists($fileDestination)) {
            $this->info("This class file already exists: $this->nameOfTheClass.php");
            return false;
        }
        // Get the original content of the file
        $fileOriginalString = $this->file->get($fileOrigin);
        $nameOfTheViewFile = Str::kebab($this->nameOfTheClass);
        $replaceFileOriginalString = str_replace('{{modelClass}}', $this->nameOfTheModelClass, $fileOriginalString);
        $replaceFileOriginalString = str_replace('{{class}}', $this->nameOfTheClass, $replaceFileOriginalString);
        $replaceFileOriginalString = str_replace('{{viewName}}', $nameOfTheViewFile, $replaceFileOriginalString);
        // Put the content into the destination directory
        $this->file->put($fileDestination, $replaceFileOriginalString);
        $this->info("Livewire CRUD class file created: $fileDestination");
    }

    protected function generateLivewireCrudViewFile()
    {
        $nameOfTheViewFile = Str::kebab($this->nameOfTheClass);
        // Set the origin and destination for the livewire class file
        $fileOrigin = base_path('/stubs/custom.livewire.crud.view.stub');
        $fileDestination = base_path("/resources/views/livewire/$nameOfTheViewFile.blade.php");
        if ($this->file->exists($fileDestination)) {
            $this->info("This view file already exists: $nameOfTheViewFile.blade.php");
            return false;
        }
        // Put the content into the destination directory
        $this->file->copy($fileOrigin, $fileDestination);
        $this->info("Livewire view file created: $fileDestination");
    }
}
