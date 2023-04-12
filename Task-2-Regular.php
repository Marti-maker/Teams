<?php
//не работи за числа по-малки от 101 и по-големи от 999
//във vs code не изкарва целият текст.
var_dump(getRegex(155,123,356));
function getRegex(int $m,int $min, int $max){
    $smallerBond=generateRegex($m,"<",null,null,true);
    $smaller=generateRegex($m,"<",null,null,false);
    $smBClear=str_replace(" ","|",$smallerBond);
    $smClear=str_replace(" ","|",$smaller);

    $biggerBond=generateRegex($m,">",null,null,true);
    $bigger=generateRegex($m,">",null,null,false);
    $bigBClear=str_replace(" ","|",$biggerBond);
    $bigClear=str_replace(" ","|",$bigger);

    $rangeBond=generateRegex($m,"==",$min,$max,true);
    $range=generateRegex($m,"==",$min,$max,false);
    $rangeBClear=str_replace(" ","|",$rangeBond);
    $rangeClear=str_replace(" ","|",$range);

    return "Every regex of given $m value with min value:$min and max value: $max \n".
        "Regex for smaller than $m with equal values is : $smBClear \n".
        "Regex for smaller than $m without equal values is : $smClear \n".
        "Regex for bigger than $m with equal values is : $bigBClear \n".
        "Regex for bigger than $m without equal values is : $bigClear \n".
        "Regex for range min :$min and max: $max with equal values is : $rangeBClear \n".
        "Regex for range min :$min and max: $max without equal values is : $rangeClear \n";

}
function generateRegex(?int $n,string $process,?int $min,?int $max,bool $boundaries){
    $regex=[];
    if($process=='<') {
        for ($x = 0; $x < 3; $x++) {
            $stringN = strval($n);
            if ($x == 0) {
                $stringN = strval($n);
                $temp = $stringN[2];
                $temp = $boundaries ? $temp : $temp -= 1;
                $regex[] = substr($stringN, 0, 2) . "[0-$temp]";
                $stringN = strval($n);

            }
            if ($x == 1) {
                $stringN = strval($stringN -= 10);
                $exp = "$stringN[0]" . "[0-$stringN[1]]" . "[0-9]";
                $regex[] = $exp;
                $stringN = strval($n);

            }
            if ($x == 2) {
                $temp = intval($stringN[0]);
                $exp2 = $temp--;
                $temp = $temp == 0 ? "" : "[0-$temp]";
                $exp = "$temp" . "[0-9]" . "[0-9]";
                $regex[] = $exp;
            }

        }
    }
    if($process=='>'){
        for($x=0; $x <= 3;$x++){
            $stringN = strval($n);
            if($x==0){
                $stringN=strval($n);
                $temp=$stringN[2];
                $temp=$boundaries ? $temp : $temp+=1 ;
                $regex[] = substr($stringN,0,2)."[$temp-9]";
            }
            if($x==1){
                $stringN = strval($stringN += 10);
                $regex[]="$stringN[0]"."[$stringN[1]-9]"."[0-9]";

            }
            if($x == 2){
                $stringN =strval($stringN+=100);
                $regex[] ="[$stringN[0]-9]"."[0-9]{2}";
            }
            if($x == 3){
                $regex[]="[$stringN[0]-9]"."[0-9]{3,}";
            }
        }
    }
    if($process=='=='){
        for ($x=0;$x<=4;$x++){
            $stringMin = strval($min);
            $stringMax =strval($max);
            if($x==0){
                $temp=$stringMin[2];
                $temp=$boundaries ? $temp : $temp+=1;
                $regex[]=substr($stringMin,0,2)."[$temp-9]";
            }
            if($x==1){
                $num=$regex[0];
                if($num[0]!=$stringMax[0]) {
                    $temp = $stringMin[1];
                    $temp++;
                    $regex[] = "$stringMin[0]" . "[$temp-9]" . "[0-9]";
                }
                else{
                    if($num[1]!=$stringMax[1]){
                        $regex[]="$stringMin[0]"."[$stringMin[1]-$stringMax[1]]"."[0-9]";
                    }
                    else{
                        $regex[]="$stringMin[0]"."$stringMin[1]"."[$stringMin[2]-$stringMax[2]";
                    }
                }
            }
            if($x==2){
                $num=$regex[1];
                if($num[0]==$stringMax[0]){
                    if($num[1]==$stringMax[1]){
                        $regex[]="$stringMin[0]"."$stringMin[1]"."$stringMin[2]-$stringMax[2]";
                    }
                    else{
                        $regex[]="$stringMin[0]"."[$stringMin-9]"."[0-9]";
                    }
                }
                else{
                    if($stringMax[0]!=$stringMin[0]){
                        $temp1=$stringMin[0];
                        $temp1++;
                        $temp2=$stringMax[0];
                        $temp2--;

                        $regex[]="[$temp1-$temp2]"."[0-9]"."{2}";
                    }
                    else{
                        if($stringMax[1]!=$stringMin[1]){

                            $regex[]="$stringMin[1]"."$stringMin[1]-$stringMax[1]"."[0-9]";
                        }
                        else{
                            $regex[]="$stringMin[0]"."$stringMin[1]"."[0-$stringMax[2]";
                        }
                    }

                }
            }
            if($x==3){
                $stringMax1=intval($stringMax[1]);
                $stringMax2=intval($stringMax[2]);

                if($boundaries){
                    $stringMax1--;
                    $regex[]="$stringMax[0]"."[0-$stringMax1]"."[0-9]";
                    $regex[]="$stringMax[0]"."$stringMax[1]"."[0-$stringMax2]";
                }else{
                    $stringMax2--;
                    $stringMax1--;
                    $regex[]="$stringMax[0]"."[0-$stringMax1]"."[0-9]";
                    $regex[]="$stringMax[0]"."$stringMax[1]"."[0-$stringMax2]";
                }

            }

        }
    }
    return $regex= implode( " ", $regex);

}
