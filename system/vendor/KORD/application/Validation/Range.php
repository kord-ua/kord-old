<?php

namespace KORD\Validation;

/**
 * Allows you to validate if a given value is greater/less than other value 
 * or is between two other values.
 * 
 * <b>Options:</b>
 * 
 * <b>'inclusive'</b> => boolean, Whether to do inclusive comparisons, allowing 
 * equivalence to min and/or max.<br>
 * <b>'min'</b> => scalar, minimum border<br>
 * <b>'max'</b> => scalar, maximum border<br>
 * <b>'step'</b> => scalar, iteration step<br>
 * <b>'base_value'</b> => scalar, base value to step from
 */
class Range extends RangeSrc {}
