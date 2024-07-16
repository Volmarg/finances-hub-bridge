<?php

namespace FinancesHubBridge\Enum;

/**
 * All the states in which the transaction can be in (coming from finances hub)
 */
enum PaymentStatusEnum
{
    // new transaction, nothing has been done with it yet
    case PENDING;

    // transaction finished with success, tool accepted the founds, money was transferred
    case SUCCESS;

    // transaction is finished with success, however the user either paid more or less than required
    case SUCCESS_NOT_EQUAL_DEMANDED;

    // user finished payment on his side, the tool needs to provide response
    case IN_PROGRESS;

    // something went wrong on some step
    case ERROR;

    // no idea what is happening
    case UNKNOWN;

    // the payment has been cancelled
    case CANCELLED;

    // founds were returned
    case RETURNED;

    // transaction process has started, this state is coming directly (AND ONLY) after status "PENDING"
    case TRIGGERED;

}
