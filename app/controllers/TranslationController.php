<?php
class TranslationController extends BaseController {
    public static function getText($lang, $text){
        $textOrigunAtt = 'Translations_'.$from;
        $translation = Translation::where($textOrigunAtt, $text)->get->first();
        if ($translation){
            $textTargetAtt = 'Translations_'.$to;
            if (!is_null($translation->{$textTargetAtt}) and strlen($translation->{$textTargetAtt})>0){
                return $translation->{$textTargetAtt};
            } else {
                $target = self::translate($text);
                $translation->{$textTargetAtt} = $target;
                $translation->save();
                return $target;
            }
            return $translation->{$textTargetAtt};
        } else {
            return $text;
        }
    }
    private static function translate($text){  }
}