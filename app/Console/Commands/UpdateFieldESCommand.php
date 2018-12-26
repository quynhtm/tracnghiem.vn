<?php

namespace App\Console\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Elasticsearch\Common\Exceptions\NoNodesAvailableException;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;

class UpdateFieldESCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:update_field {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reindex elasticsearch ';

    protected $client;

    /**
     * Create a new command instance.
     *
     * @param $client
     * @return void
     */
    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Indexing. Might take a while...');
        $class = $this->argument('model');

        $model = App::make('\\App\\Http\\Models\\Admin\\' . $class);
        $dbName = $model->getTable();
        $total = DB::table($dbName)->count();
        $models = DB::table($dbName)->limit(10000)->offset(0)->get();
        
        $models = json_decode($models, true);

        try {
            $count = 0;
            $params = [];

            $params['index'] = 'vm_'.$dbName;
            $params['type'] = '_doc';
            $params['body'] = ELASTIC_MAPPINGS[$class]['mappings']['_doc'];
            $res = $this->client->indices()->putMapping($params);

            $this->info("\nDone!");
        } catch (NoNodesAvailableException $e) {
            \Log::info('|=======> ES NoNodesAvailableException: ' . $e->getMessage());
        } catch (BadRequest400Exception $e) {
            \Log::info('|=======> ES BadRequest400Exception: ' . $e->getMessage());
        } catch (\Exception $e) {
            \Log::info('|=======> ES Error: ' . $e->getMessage());
        }
    }
}