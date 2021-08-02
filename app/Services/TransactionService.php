<?php
    namespace App\Services;

    use Exception;
    use App\Models\Transaction;
    use Illuminate\Support\Facades\DB;

class TransactionService {

    public function create($transaction) {
        try {
            DB::beginTransaction();
                Transaction::create($transaction);
            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            echo response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}