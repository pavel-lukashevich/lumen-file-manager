<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\File;
use App\Models\User;

class UpdateAverageRateJob extends Job
{
    /** @var File $file */
    public $file;

    /** @var User $user */
    public $user;

    /**
     * UpdateAverageRateJob constructor.
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->file->average_rate = round($this->file->ratings()->avg('rating'), 2);
        $this->file->save();

        /** @var Category $category */
        foreach ($this->file->categories()->cursor() as $category) {
            $category->average_rate = round($category->files()->avg('average_rate'), 2);
            $category->save();
        }
    }
}
