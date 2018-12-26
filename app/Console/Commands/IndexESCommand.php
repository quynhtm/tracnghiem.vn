<?php

namespace App\Console\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Elasticsearch\Common\Exceptions\NoNodesAvailableException;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;

class IndexESCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:index {model}';

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

            $mapping['index'] = 'vm_'.$dbName;
            $mapping['body'] = ELASTIC_MAPPINGS[$class];
            $res = $this->client->indices()->create($mapping);

            for ($i = 0; $i < $total; $i++)
            {
                // $models[$count]['location'] = str_replace('-', ',', $models[$count]['location']);
                $params['body'][] = [
                    'index' => [
                        '_index' => 'vm_'.$dbName,
                        '_type' => '_doc',
                        '_id' => $models[$count]['id'],
                    ],
                ];

                $params['body'][] = $models[$count];
                $count++;

                if (($i + 1) % 10000 == 0) {
                    $responses = $this->client->bulk($params);
                    $params = [];

                    unset($models);
                    unset($responses);

                    $models = DB::table($dbName)->limit(10000)->offset($i)->get();
                    $models = json_decode($models, true);
                    $count = 0;
                    $this->output->write('.');
                }

                // $res = $this->client->index([
                //     'index' => $dbName,
                //     'type' => '_doc',
                //     'id' => $models[$i]['id'],
                //     'body' => $models[$i]
                // ]);
                // dd($res);
            }

            if (!empty($params['body'])) {
                $responses = $this->client->bulk($params);
            }

            $this->info("\nDone!");
        } catch (NoNodesAvailableException $e) {
            print_r($e->getMessage());
        } catch (BadRequest400Exception $e) {
            print_r($e->getMessage());
        }
    }
}