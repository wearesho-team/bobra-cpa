<?php

namespace Wearesho\Bobra\Cpa;

/**
 * Interface CpaPermission
 * @package Wearesho\Bobra\Cpa
 */
interface CpaPermission
{
    /** Usually only clients can create leads */
    const CREATE_LEADS = 'createLead';
    const CREATE_CONVERSIONS_REPORTS = 'createConversionReports';
}
