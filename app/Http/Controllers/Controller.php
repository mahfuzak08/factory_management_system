<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Fiscal_year;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    protected $fysd;
    protected $fyed;

    public function __construct()
    {
        $afy = Fiscal_year::where('is_active', 'yes')->get();
        if(!empty($afy[0])){
            $this->fysd = $afy[0]->start_date;
            $this->fyed = $afy[0]->end_date;
        }else{
            $this->fysd = date('Y').'-01-01';
            $this->fyed = date('Y').'-12-31';
        }
    }

    public function isSameSubnet($ip1, $ip2, $subnetMask = 24)
    {
        // Convert IP addresses to binary strings
        $binaryIp1 = inet_pton($ip1);
        $binaryIp2 = inet_pton($ip2);

        // Extract network portions based on the subnet mask
        $networkPortionIp1 = substr($binaryIp1, 0, $subnetMask / 8);
        $networkPortionIp2 = substr($binaryIp2, 0, $subnetMask / 8);

        // Compare network portions
        return $networkPortionIp1 === $networkPortionIp2;
    }
}
