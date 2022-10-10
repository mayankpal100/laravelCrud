<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\propertyType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class DataCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Scan:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        API_KEY should be added in env file while testing , for no error i am adding into default as of now
        $data = Http::get('https://trial.craig.mtcserver15.com/api/properties?api_key='.env('API_KEY' , "3NLTTNlXsi6rBWl7nYGluOdkl2htFHug"))->body();
        for ($i = 1; $i <= json_decode($data, true)['last_page']; $i++) {
            $data = Http::get("https://trial.craig.mtcserver15.com/api/properties?api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug&page%5Bnumber%5D=$i")->body();
            dump($i);
            foreach (json_decode($data, true)['data'] as $key) {
                Property::query()->updateOrCreate(
                    [
                        "uuid" => $key['uuid']
                    ], $key);
                if (isset($key['property_type']) && PropertyType::query()->find($key['property_type']['id']) == null) {
                    PropertyType::query()->create($key['property_type']);
                }
            }
        }

        return true;
    }
}
