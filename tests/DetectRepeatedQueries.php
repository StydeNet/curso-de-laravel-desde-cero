<?php

namespace Tests;

use Illuminate\Support\Facades\DB;

trait DetectRepeatedQueries
{
    public function enableQueryLog()
    {
        DB::connection('enlighten')->enableQueryLog();
    }

    /**
     * Assert there are not repeated queries being executed.
     */
    public function assertNotRepeatedQueries()
    {
        $queries = array_column(DB::connection('enlighten')->getQueryLog(), 'query');

        $selects = array_filter($queries, function ($query) {
            return strpos($query, 'select') === 0;
        });

        $selects = array_count_values($selects);

        foreach ($selects as $select => $amount) {
            $this->assertEquals(
                1,
                $amount,
                "The following SELECT was executed $amount times:\n\n $select"
            );
        }
    }

    public function flushQueryLog()
    {
        DB::connection('enlighten')->flushQueryLog();
    }
}
