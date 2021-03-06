<?php
/**
 * Created by PhpStorm.
 * User: MyBe
 * Date: 08.02.2017
 * Time: 10:49
 */
use app\models\Product;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <label for="search">Пошук продуктів:</label>

        <?php echo AutoComplete::widget([
            'id' => 'search',
            'clientOptions' => [
                'source' =>  Url::toRoute(['/user/admin/autocomplate']),
                'dataType'=>'json',
                'autoFill'=>true,
                'minLength' => 3,
                'open' => new JsExpression('function( event, ui ) {
                    $(".ui-autocomplete").hide();
                }
                '),
                'response' => new JsExpression('
                    function( event, ui ) {
                    var products = \'\';
                    var len_size = ui.content.length;
                    if(len_size) {
                        for(var product of ui.content){
                                if(product.sub_category === null || product.photo_url === null) {
                                    products += \'<li class="contact"><div class="search-item"><img class="contact-image" src="/images/no_img.png" /></div><div class="contact-info"><div class="contact-number"> \' + product.product_name +\' </div><div class="contact-price">\' + product.price +\' грн.</div></div><div class="setting"><div class="setting-part"> <label for="qty" id="qty-label" >Кількість:</label><input type="text" maxlength="3" class="form-control qty" value="1"></div><div class="setting-part"> <input type="button" class="btn btn-info replace-confirm confirm-\' + product.id +\'"  data-id="\' + product.id +\'" value="Замінити"></div></div></div></li>\';
                                
                                } else {
                                products += \'<li class="contact"><div class="search-item"><img class="contact-image" src="\'+ product.photo_url +\'" /></div><div class="contact-info"><div class="contact-name"> \' + product.sub_category + \' </div><div class="contact-number"> \' + product.product_name +\' </div><div class="contact-price">\' + product.price +\' грн.</div></div><div class="setting"><div class="setting-part"> <label for="qty" id="qty-label" >Кількість:</label><input type="text" maxlength="3" class="form-control qty" value="1"></div><div class="setting-part"> <input type="button" class="btn btn-info replace-confirm confirm-\' + product.id +\'"  data-id="\' + product.id +\'" value="Замінити"></div></div></div></li>\';
                                }
                                $(".media-list").html(products);
                             }
                     } else {
                        $(".media-list").html("<li class=\"contact\">Нічого не знайдено!</li>");
                     }
                     subscribeEvents();
                     $(".qty").keypress(function (e) {
                        if (e.which != 8 && e.which != 46  && (e.which < 48 || e.which > 57)){
            return false;
        }
                      });
                    }
                    '),
                'select' => new JsExpression('
                    function( event, ui ) {
                    $(".replace-confirm").css("display","initial");
                    $("#qty-label").css("display","initial");
                    $(".qty").css("display","initial");
                        var product = \'<li class="contact"><div class="search-item"><img class="contact-image" src="\'+ ui.item.photo_url +\'" /></div><div class="contact-info"><div class="contact-name"> \' + ui.item.sub_category + \' </div><div class="contact-number"> \' + ui.item.product_name +\' </div><div class="contact-price">\' + ui.item.price +\' грн.</div></div></div></li>\';
                       $(".media-list").html(product);
                       $(".replace-confirm").attr(\'data-id\', ui.item.id);
                    }
                    ')

            ],
            'options' => [
                'class' => 'form-control'
            ],
        ]);?>
    </div>

    <ul class="media-list">
    </ul>
<?php ActiveForm::end(); ?>
<?php $this->registerJs(
    '$("document").ready(function(){
        
        
    });'
);
?>