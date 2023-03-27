<?php
namespace App\Http\Filters\V1;

use Illuminate\Http\Request;


class invoicesFilter {
    protected $safeParms = [
        'seira' => ['eq'],
        'invoiceID' => ['eq', 'lt', 'gt'],
        'clientId' => ['eq']
    ];

    protected $columnMap = [
      'clientId' => 'clientId'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '≤',
        'gt' => '>',
        'gte' => '≥',
    ];

    public function transform(Request $request) {
        $eloQuery = [];

        foreach($this->safeParms as $parm  => $operators) {
            $query = $request->query($parm);

            if(!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach($operators as $operator) {
                if(isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }


        return $eloQuery;
    }
}
