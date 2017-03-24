<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;

class Locations
{
    private $filename = 'locations.json';
    /**
     * @var Villagers
     */
    private $villagers;
    /**
     * @var Schedules
     */
    private $schedules;

    public function __construct(Villagers $villagers)
    {
        $this->villagers = $villagers;
    }

    /**
     * Get a list of valid locations
     *
     * @return Collection
     */
    public function getList()
    {
        try {
            $file = \Storage::get($this->filename);
            return new Collection(json_decode($file));
        } catch (FileNotFoundException $e) {
            return new Collection();
        }
    }

    private function setList(Collection $list)
    {
        \Storage::put($this->filename, $list->toJson());
    }

    /**
     * (Re-)build the locations file with all possible locations
     */
    public function buildFile()
    {
        $list = $this->getList();

        foreach($this->villagers->getList() AS $villager) {

            $villagerList = $list->get($villager) ?? new Collection();

            $schedule = (new Schedules($villager))->readFile();
            foreach($schedule AS $possibility) {
                foreach($possibility AS $step) {
                    $steps = explode(' ', $step);
                    if (preg_match('/\d?\d{3}/', $steps[0])) {
                        $location = implode(' ', array_slice($steps, 1, 3));

                        if (!$villagerList->has($location)) {
                            $villagerList->offsetSet($location, "");
                        }
                    }
                }
            }

            $list->offsetSet($villager, $villagerList);
        }

        $this->setList($list);
    }

    /**
     * Parse a list of schedules and replace the locations with names
     * @param $villager
     * @param $schedules
     */
    public function parseLocations($villager, &$schedules)
    {
        $list = new Collection($this->getList()->get($villager) ?? []);

        foreach($schedules AS &$schedule) {
            foreach($schedule AS &$step) {
                $steps = explode(' ', $step);
                $location = implode(' ', array_slice($steps, 1, 3));

                $step = [
                    'time' => $steps[0],
                    'location' => $list->get($location) ?? '??',
                    'map' => $steps[1],
                    'x' => $steps[2],
                    'y' => $steps[3],
                    'facing' => $steps[4],
                    'sprite' => $steps[5] ?? '',
                ];
            }
        }
    }

}