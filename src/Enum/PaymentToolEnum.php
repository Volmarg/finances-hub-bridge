<?php

namespace FinancesHubBridge\Enum;

enum PaymentToolEnum: string
{
    case PAYPAL = "PAYPAL";
    case STRIPE = "STRIPE";
}
