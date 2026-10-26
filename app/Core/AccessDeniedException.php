<?php
namespace App\Core;

/** An expected authorization failure, distinct from database or storage faults. */
final class AccessDeniedException extends \RuntimeException
{
}
