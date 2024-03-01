<?php

declare(strict_types=1);

namespace App\Enums\Core\AppError;

enum CodeEnum: string
{
    case C000000 = '000000'; // i am a teapot

    case C000001 = '000001'; // not found

    case C000002 = '000002'; // validation error

    case C010003 = '010003'; // jwt not found

    case C010004 = '010004'; // jwt signature invalid

    case C010005 = '010005'; // jwt expired

    case C010006 = '010006'; // access forbidden

    case C011001 = '011001'; // username is already in use

    case C011002 = '011002'; // email is already in use

    case C011003 = '011003'; // email not found

    case C011004 = '011004'; // code cannot be resubmitted

    case C011005 = '011005'; // incorrect code

    case C011006 = '011006'; // incorrect login data

    case C011007 = '011007'; // incorrect refresh token

    case C011008 = '011008'; // incorrect login provider

    case C011009 = '011009'; // authorization token expired

    case C011010 = '011010'; // invalid signature

    case C011011 = '011011'; // this account pap tracker is already in use

    case C020002 = '020002'; // global symbol setup not found

    case C030001 = '030001'; // form not found

    case C030002 = '030002'; // screen not found

    case C030003 = '030003'; // form already passed

    case C030004 = '030004'; // screen already passed

    case C040001 = '040001'; // replenishment not available

    case C040002 = '040002'; // replenishment not found

    case C050001 = '050001'; // code not found

    case C050002 = '050002'; // already used code
	
	case C060001 = '060001'; // withdrawal is not possible

    case C090001 = '090001'; // file save error

    case C100001 = '100001'; // merchant001 unavailable
}
