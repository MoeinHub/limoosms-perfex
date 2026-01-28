<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?
$token = get_option('sms_limoosms_token');
$url ='https://api.limosms.com/api/getcurrentcredit';
$process = curl_init();
curl_setopt( $process,CURLOPT_URL,$url);
curl_setopt( $process, CURLOPT_TIMEOUT,1);
curl_setopt( $process, CURLOPT_POST, 1);
curl_setopt( $process, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt( $process, CURLOPT_FOLLOWLOCATION, true);
curl_setopt( $process, CURLOPT_HTTPHEADER, array('Content-Type: application/json' ,'ApiKey:' . $token));
$return = curl_exec( $process);
$httpcode = curl_getinfo( $process, CURLINFO_HTTP_CODE);
curl_close($process);
$decoded = json_decode($return);
// print_r($decoded);
$message = "به‌نظر می‌رسد توکن شما صحیح نمی‌باشد. لطفا از صحت توکن پیامک دریافت شده از اکسیر sms اطمینان حاصل فرمایید.";
if ( $httpcode == 200 ){
    $output1 = $decoded->{"result"}->{"smsCount"};
    $output2 = $decoded->{"result"}->{"credit"};
    // $message = "میزان شارژ پنل پیامکی شما: " . app_format_money($output2, 'IRR') . " و تقریبا معادل " . $output1 . " عدد پیامک می‌باشد.";
    $message = "میزان شارژ پنل پیامکی شما معادل: " . $output1 . " عدد پیامک می‌باشد.";
}
// $message = $message . '   <a href="https://sms.eta.co.ir/" target="_blank">جهت دسترسی به سامانه اکسیر sms روی این متن کلیک کنید.</a>'

?>
<div class="widget relative" id="widget-limoosms-credit" data-name="مانده اعتبار پنل پیامکی">
      <div class="row">
          <div class="col-md-12">
              <div class="panel_s">
                  <div class="panel-body padding-10">
                      <div class="widget-dragger ui-sortable-handle"></div>
                        <p class="tw-font-semibold tw-flex tw-items-center tw-mb-0 tw-space-x-1.5 rtl:tw-space-x-reverse tw-p-1.5">
                            <span class="tw-text-neutral-700">مانده اعتبار پنل پیامکی</span>
                      </p>
                        <hr class="-tw-mx-3 tw-mt-3 tw-mb-6">
                        <?php print $message; ?>
                        <?php //print app_format_money($output2, 'IRR'); ?><br>
                        <div class="tw-text-center tw-mt-3">
                            <a href="https://sms.eta.co.ir/" class="btn btn-primary btn-sm">
                                شارژ پنل اکسیر پیامک
                            </a>
                        </div>
                  </div>
              </div>
          </div>
      </div>
  </div>