<?php
namespace App\Http\Filters\V1;

use Illuminate\Http\Request;
use App\Http\Filters\ApiFilter;

class invoicesFilter extends ApiFilter {
    protected $safeParms = [
        'seira' => ['eq'],
        'invoiceID' => ['eq', 'lt', 'gt', 'gte', 'lte'],
        'date' => ['eq', 'lt', 'gt', 'gte', 'lte'],
        'clientId' => ['eq'],
        'vat' =>  ['eq']
    ];

    protected $columnMap = [
      'clientId' => 'client_id'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];

    public function transform(Request $request) {
        $eloQuery = [];
//dd($request);
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
