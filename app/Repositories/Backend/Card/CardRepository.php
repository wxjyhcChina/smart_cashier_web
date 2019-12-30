<?php
/**
 * Created by PhpStorm.
 * User: billy
 * Date: 2018/9/13
 * Time: 16:33
 */

namespace App\Repositories\Backend\Card;

use App\Exceptions\Api\ApiException;
use App\Exceptions\GeneralException;
use App\Modules\Enums\CardStatus;
use App\Modules\Enums\ErrorCode;
use App\Modules\Models\Card\Card;
use App\Modules\Repositories\Card\BaseCardRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class CardRepository
 * @package App\Repositories\Backend\Card
 */
class CardRepository extends BaseCardRepository
{
    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query();
    }

    /**
     * @param $input
     * @return Card
     * @throws GeneralException
     * @throws \App\Exceptions\Api\ApiException
     */
    public function create($input)
    {
        $this->cardExist($input['number'], $input['internal_number']);
        $card = $this->createCardStub($input);

        if ($card->save())
        {
            return $card;
        }

        throw new GeneralException(trans('exceptions.backend.card.create_error'));
    }

    /**
     * @param $sheets
     * @throws GeneralException
     * @return mixed
     */
    public function createMultipleCards($cards)
    {
        try{
            DB::beginTransaction();

            foreach ($cards as $input)
            {
                if ($input['number'] == null)
                {
                    continue;
                }

                try
                {
                    $this->create($input);
                }
                catch (ApiException $exception)
                {
                    if ($exception->getCode() == ErrorCode::CARD_ALREADY_EXIST)
                    {
                        continue;
                    }
                    else
                    {
                        throw $exception;
                    }
                }
            }

            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            throw new GeneralException(trans('exceptions.backend.card.create_error'));
        }
    }


    /**
     * @param Card $card
     * @param $enabled
     * @return bool
     * @throws GeneralException
     */
    public function mark(Card $card, $enabled)
    {
        $card->enabled = $enabled;

        if ($card->save()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.card.mark_error'));
    }

    /**
     * @param $input
     * @return Card
     */
    private function createCardStub($input)
    {
        $card = new Card();
        $card->number = $input['number'];
        $card->internal_number = isset($input['internal_number']) ? $input['internal_number'] : '';
        $card->status = CardStatus::UNACTIVATED;

        return $card;
    }
}