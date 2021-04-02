<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class InitSystemRequirements
{
    public function getBrowesrTimeZone()
    {
        /*echo "<script>
                var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                document.cookie = 'timezone='+timezone+';path=/';
            </script>";*/
    }

    public function getBrowesrLatLong()
    {
        /*echo "<script>
            getLocation();

            function getLocation() 
            {
                if (navigator.geolocation)
                    navigator.geolocation.getCurrentPosition(showPosition);
                else
                    alert('Geolocation is not supported by this browser.');
            }

            function showPosition(position) 
            {
                document.cookie = 'latitude='+position.coords.latitude+';path=/';
                document.cookie = 'longitude='+position.coords.longitude+';path=/';
            }
            </script>";*/
    }
}
