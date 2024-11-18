<?php

namespace App\Http\Controllers\Payroll;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\TaxRule;

class TaxSetupController extends Controller
{
    public function index()
    {
        $femaleTaxes = TaxRule::whereGender('Female')->get();
        $maleTaxes   = TaxRule::whereGender('Male')->get();

        return view('admin.payroll.setup.taxSetup', compact('femaleTaxes', 'maleTaxes'));
    }

    public function updateTaxRule(Request $request)
    {
        $input = $request->all();
        $data  = TaxRule::findOrFail($request->get('tax_rule_id'));

        try {
            $data->update($input);
            return response()->json(['message' => 'Tax rule update successful.']);
        } catch (QueryException $qe) {
            Log::error(
                'An error occurred in the query: ',
                [
                    'error_message' => $qe->getMessage(),
                    'code' => $qe->getCode(),
                    'stack_trace' => $qe->getTraceAsString(),
                    'query' => $qe->getSql(),
                    'bindings' => $qe->getBindings()
                ]
            );
            return response()->json(['message' => 'An error occurred while updating tax rule. Please try again.'], 404);
        } catch (\Exception $e) {
            Log::critical(
                'An error occurred: ',
                ['error_message' => $e->getMessage(), 'code' => $e->getCode(), 'stack_trace' => $e->getTraceAsString()]
            );
            return response()->json(['message' => 'An internal error occurred. Please contact administrator.'], 500);
        }
    }
}
