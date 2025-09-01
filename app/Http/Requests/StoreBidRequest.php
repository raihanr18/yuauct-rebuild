<?php

namespace App\Http\Requests;

use App\Models\Auction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoreBidRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $result = Auth::check() && $user && $user->role === 'user';
        
        return $result;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        try {
            $auctionId = $this->route('auction');
            
            $auction = Auction::find($auctionId);
            if (!$auction) {
                return [
                    'bid_amount' => ['required', 'numeric', 'min:1000']
                ];
            }
            
            $currentBid = $auction->current_bid ?? 0;
            
            return [
                'bid_amount' => [
                    'required',
                    'numeric',
                    'min:' . ($currentBid + 1000), // Minimum increment of 1000
                ],
            ];
        } catch (\Exception $e) {
            Log::error('Error in StoreBidRequest rules()', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'bid_amount' => ['required', 'numeric', 'min:1000']
            ];
        }
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        try {
            $auctionId = $this->route('auction');
            $auction = Auction::find($auctionId);
            $currentBid = $auction ? $auction->current_bid ?? 0 : 0;
            
            return [
                'bid_amount.required' => 'Jumlah penawaran harus diisi.',
                'bid_amount.numeric' => 'Jumlah penawaran harus berupa angka.',
                'bid_amount.min' => 'Penawaran minimal adalah Rp ' . number_format($currentBid + 1000, 0, ',', '.'),
            ];
        } catch (\Exception $e) {
            Log::error('Error in StoreBidRequest messages()', ['error' => $e->getMessage()]);
            
            return [
                'bid_amount.required' => 'Jumlah penawaran harus diisi.',
                'bid_amount.numeric' => 'Jumlah penawaran harus berupa angka.',
                'bid_amount.min' => 'Penawaran harus lebih tinggi dari penawaran sebelumnya.',
            ];
        }
    }
}
