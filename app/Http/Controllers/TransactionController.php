<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Services\TransactionService;
    use App\Services\UserService;
    use App\Exceptions\UserNotFound;
    use App\Exceptions\InvalidOperation;
    use App\Exceptions\InvalidValue;
    use App\Exceptions\InsufficientFunds;
    use App\Services\WalletService;

class TransactionController extends Controller {

        private function validateRequest(Request $request) {
            $this->validate($request, [
                'payer' => 'required',
                'payee' => 'required',
                'value' => 'required',
            ]);    
        }


        private function validateUsers($payerId, $payeeId){
            $hasPayer = UserService::getById($payerId); //Pagador
            $hasPayee = UserService::getById($payeeId);

            if ($payerId === $payeeId) {
                throw new InvalidOperation("Payee don't can equal to Payer", 400);
            }

            if (!$hasPayer) {
                throw new UserNotFound("Payer not Found", 404);
            }

            if (!$hasPayee) {
                throw new UserNotFound("Payee not Found", 404);
            }

            if ($hasPayer && $hasPayer->type === 'SHOPKEEPER'){
                throw new InvalidOperation("Shopkeeper don't can are Payer", 400);
            }
        }   

        private function validateValueTransaction($value, $payerId) {
            $wallet = new WalletService();
            $balance = $wallet->getBalance($payerId);
            
            if (!$value) {
                throw new InvalidValue("Value must be greater than 0", 400);
            }

            if ($balance < $value) {
                throw new InsufficientFunds("Insufficient Funds", 400);
            }
        }

        //TODO: Cada transação gera dois registros
        //Um crédito na conta do payee
        //Um débito na conta do payer
        public function create(Request $request){
            try {
                $this->validateRequest($request);
                $this->validateUsers($request->payer, $request->payee);
                $this->validateValueTransaction($request->value, $request->payer);
            }catch (\Exception $e) {
                return response()
                    ->json([
                        "error" => $e->getMessage()
                    ], $e->getCode());
                
            }

            // $transaction = new TransactionService();
            // $transaction->create($request->all());
            
        }
    }