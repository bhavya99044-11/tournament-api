<?php

namespace App;

enum TournamentStatus:string
{
      case Pending = 'pending';

    case Active = 'active';

    case Inactive = 'inactive';

    case Rejected = 'rejected';
}
