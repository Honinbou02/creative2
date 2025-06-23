<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplateSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('email_templates')->delete();

    $email_templates = array(
          array('id' => '1','name' => 'Welcome Email','subject' => 'Welcome Email-2','slug' => 'welcome-email','code' => '<div style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:0 auto; max-width: 600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                <tbody>
                  <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
    
                      <!--begin:Email content-->
                      <div style="text-align:center; margin:0 15px 34px 15px">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px">
                          <a href="https://writebot.themetags.com/" rel="noopener" target="_blank">
                            
                          </a>
                        </div>
                        <!--end:Logo-->
    
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                          </div><div style="margin-bottom: 15px"><img style="width: 162px;" src="https://writerap.themetags.net/uploads/media/logo%20(1).png?v=1738591539"></div><div style="margin-bottom: 15px"><img alt="Logo" src="https://writebot.themetags.com/public/images/like.svg" style="width: 120px; margin:40px auto;">
                        </div>
                        <!--end:Media-->
    
                        <!--begin:Text-->
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                          <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">hello someting [name],
                            thanks for
                            signing up!</p>
                         
                        </div>
                        <!--end:Text-->
    
                      </div>
                      <!--end:Email content-->
                    </td>
                  </tr> 
    
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                      <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ">
                        It’s all about customers!</p>
                      <p style="margin-bottom:2px">Call our customer care number: 540-907-0453</p>
                      <p style="margin-bottom:4px">You may reach us at <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600">admin@themetags.com</a>.
                      </p>
                      <p>We serve Mon-Fri, 9AM-18AM</p>
                    </td>
                  </tr>  
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                      <p> © Copyright ThemeTags.
                        <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;
                        from newsletter.
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>','type' => 'welcome-email','variables' => '[name], [email], [phone]','user_id' => '1','is_active' => '1','created_by_id' => NULL,'updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-02-03 14:14:59'),
          array('id' => '2','name' => 'Registration Verification','subject' => 'Registration Verification-e','slug' => 'registration-verification','code' => '<div style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:0 auto; max-width: 600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                <tbody>
                  <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
    
                      <!--begin:Email content-->
                      <div style="text-align:center; margin:0 15px 34px 15px">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px">
                          <a href="https://writebot.themetags.com/" rel="noopener" target="_blank">
                            
                          </a>
                        </div>
                        <!--end:Logo-->
    
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                          </div><div style="margin-bottom: 15px"><img src="https://writerap.themetags.net/uploads/media/logo%20(1).png?v=1738591539" style="width: 162px;"><br></div><div style="margin-bottom: 15px"><img alt="Logo" src="https://writebot.themetags.com/public/images/like.svg" style="width: 120px; margin:40px auto;">
                        </div>
                        <!--end:Media-->
    
                        <!--begin:Text-->
                        <div style="font-size: 14px; margin-bottom: 27px; font-family: Arial, Helvetica, sans-serif;">
                          <p style="margin-bottom: 9px; color: rgb(24, 28, 50); font-size: 22px;"><b><u><i>Hey
                            [name],
                            thanks for
                            signing up!</i></u></b></p>
                          <h4 style="font-weight: 500; margin-bottom: 2px; color: rgb(126, 130, 153);">Email Verification
                          </h4>
                          <p style="font-weight: 500; margin-bottom: 2px; color: rgb(126, 130, 153);">paragraphs. Please click the button below to verify your email address
                          </p>
                         
                        </div>
                        <!--end:Text-->
    
                        <!--begin:Action-->
                        <a href="[active_url]" target="_blank" style="background-color:#29a762; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">
                          Activate Account
                        </a>
                        <!--begin:Action-->
                      </div>
                      <!--end:Email content-->
                    </td>
                  </tr> 
    
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                      <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ">
                        It’s all about customers!</p>
                      <p style="margin-bottom:2px">Call our customer care number: 540-907-0453</p>
                      <p style="margin-bottom:4px">You may reach us at <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600">admin@themetags.com</a>.
                      </p>
                      <p>We serve Mon-Fri, 9AM-18AM</p>
                    </td>
                  </tr>  
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                      <p> © Copyright ThemeTags.
                        <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;
                        from newsletter.
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>','type' => 'registration-verification','variables' => '[name], [email], [phone]','user_id' => '1','is_active' => '2','created_by_id' => NULL,'updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-02-03 14:07:46'),
          array('id' => '3','name' => 'Add New Customer Welcome Email','subject' => 'Add New Customer Welcome Email','slug' => 'add-new-customer-welcome-email','code' => '<div style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
          <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:0 auto; max-width: 600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
              <tbody>
                <tr>
                  <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
    
                    <!--begin:Email content-->
                    <div style="text-align:center; margin:0 15px 34px 15px">
                      <!--begin:Logo-->
                      <div style="margin-bottom: 10px"><img src="https://writerap.themetags.net/uploads/media/logo%20(1).png?v=1738591539" style="width: 162px;"><a href="https://writebot.themetags.com/" rel="noopener" target="_blank">
                        </a>
                      </div>
                      <!--end:Logo-->
    
                      <!--begin:Media-->
                      <div style="margin-bottom: 15px">
                        <img alt="Logo" src="https://writebot.themetags.com/public/images/like.svg" style="width: 120px; margin:40px auto;">
                      </div>
                      <!--end:Media-->
    
                      <!--begin:Text-->
                      <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                        <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hi [name],
                        We have created account for you . your login credentails here :
                          Email : [email]
                          Phone : [phone]
                          password : [password]
                          <strong> and your package info</strong>:
                          Package name : [package]
                          Price : [price]
                          Payment Method : [method]
                          Start Date : [startDate]
                          End Date : [endDate]
                          </p>
                       
                      </div>
                      <!--end:Text-->
                      <!--begin:Action-->
                      <a href="[login_url]" target="_blank" style="background-color:#29a762; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">
                        Login
                      </a>
                      <!--begin:Action-->
                    </div>
                    <!--end:Email content-->
                  </td>
                </tr> 
    
                <tr>
                  <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                    <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ">
                      It’s all about customers!</p>
                    <p style="margin-bottom:2px">Call our customer care number: 540-907-0453</p>
                    <p style="margin-bottom:4px">You may reach us at <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600">admin@themetags.com</a>.
                    </p>
                    <p>We serve Mon-Fri, 9AM-18AM</p>
                  </td>
                </tr>  
                <tr>
                  <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                    <p> © Copyright ThemeTags.
                      <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;
                      from newsletter.
                    </p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>','type' => 'add-new-customer-welcome-email','variables' => '[name], [email], [phone], [password], [package], [startDate], [endDate], [price], [method]','user_id' => '1','is_active' => '3','created_by_id' => NULL,'updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-02-03 14:08:02'),
          array('id' => '4','name' => 'Purchase Package','subject' => 'Purchase Package','slug' => 'purchase-package','code' => '<div style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:0 auto; max-width: 600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                <tbody>
                  <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
    
                      <!--begin:Email content-->
                      <div style="text-align:center; margin:0 15px 34px 15px">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px"><img src="https://writerap.themetags.net/uploads/media/logo%20(1).png?v=1738591539" style="width: 162px;"><a href="https://writebot.themetags.com/" rel="noopener" target="_blank">
                          </a>
                        </div>
                        <!--end:Logo-->
    
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                          <img alt="Logo" src="https://writebot.themetags.com/public/images/like.svg" style="width: 120px; margin:40px auto;">
                        </div>
                        <!--end:Media-->
    
                        <!--begin:Text-->
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                          <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hi
                            [name],
                            thanks for
                            purchase [package].</p>
                            <p>Your [Package] price [price] and start from [startDate]</p>
                            <p>Your [Package] Will be expire [endDate]</p>                                 
                        </div>
                        
                      </div>
                      <!--end:Email content-->
                    </td>
                  </tr> 
    
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                      <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ">
                        It’s all about customers!</p>
                      <p style="margin-bottom:2px">Call our customer care number: 540-907-0453</p>
                      <p style="margin-bottom:4px">You may reach us at <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600">admin@themetags.com</a>.
                      </p>
                      <p>We serve Mon-Fri, 9AM-18AM</p>
                    </td>
                  </tr>  
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                      <p> © Copyright ThemeTags.
                        <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;
                        from newsletter.
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>','type' => 'purchase-package','variables' => '[name], [email], [phone], [package],[startDate], [endDate],[price]','user_id' => '1','is_active' => '4','created_by_id' => NULL,'updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-02-03 14:08:13'),
          array('id' => '5','name' => 'Admin Assign Package','subject' => 'Admin Assign Package','slug' => 'admin-assign-package','code' => '<div style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:0 auto; max-width: 600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                <tbody>
                  <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
    
                      <!--begin:Email content-->
                      <div style="text-align:center; margin:0 15px 34px 15px">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px"><img src="https://writerap.themetags.net/uploads/media/logo%20(1).png?v=1738591539" style="width: 162px;"><br></div>
                        <!--end:Logo-->
    
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                          <img alt="Logo" src="https://writebot.themetags.com/public/images/like.svg" style="width: 120px; margin:40px auto;">
                        </div>
                        <!--end:Media-->
    
                        <!--begin:Text-->
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                          <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hi
                            [name],
                           Admin Assigned this <strong>[package]</strong> for you.
                            purchase <strong>[package]</strong>.</p>
                            <p>Your  <strong>[package]</strong> price  <strong>[price]</strong> and start from [startDate]</p>
                            <p>Your [Package] Will be expire <strong>[endDate]</strong></p>
                
                         
                        </div>
                        <!--end:Text-->
    
                      </div>
                      <!--end:Email content-->
                    </td>
                  </tr> 
    
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                      <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ">
                        It’s all about customers!</p>
                      <p style="margin-bottom:2px">Call our customer care number: 540-907-0453</p>
                      <p style="margin-bottom:4px">You may reach us at <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600">admin@themetags.com</a>.
                      </p>
                      <p>We serve Mon-Fri, 9AM-18AM</p>
                    </td>
                  </tr>  
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                      <p> © Copyright ThemeTags.
                        <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;
                        from newsletter.
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>','type' => 'admin-assign-package','variables' => '[name], [email], [phone], [package],[startDate], [endDate],[price]','user_id' => '1','is_active' => '5','created_by_id' => NULL,'updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-02-03 14:08:22'),
          array('id' => '6','name' => 'Offline Payment Request','subject' => 'Offline Payment Request','slug' => 'offline-payment-request','code' => '<div style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:0 auto; max-width: 600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                <tbody>
                  <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
    
                      <!--begin:Email content-->
                      <div style="text-align:center; margin:0 15px 34px 15px">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px"><img src="https://writerap.themetags.net/uploads/media/logo%20(1).png?v=1738591539" style="width: 162px;"><a href="https://writebot.themetags.com/" rel="noopener" target="_blank">
                          </a>
                        </div>
                        <!--end:Logo-->
    
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                          <img alt="Logo" src="https://writebot.themetags.com/public/images/like.svg" style="width: 120px; margin:40px auto;">
                        </div>
                        <!--end:Media-->
    
                        <!--begin:Text-->
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                          <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hi, <br>
                           [name] request a offline payment for purchase <strong>[package]</strong> using this payment method <strong>[method]</strong> .</p>
                            <p>And  <strong>[package]</strong> price  <strong>[price]</strong></p>                         
    
                         
                        </div>
                        <!--end:Text-->
    
                      </div>
                      <!--end:Email content-->
                    </td>
                  </tr> 
    
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                      <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ">
                        It’s all about customers!</p>
                      <p style="margin-bottom:2px">Call our customer care number: 540-907-0453</p>
                      <p style="margin-bottom:4px">You may reach us at <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600">admin@themetags.com</a>.
                      </p>
                      <p>We serve Mon-Fri, 9AM-18AM</p>
                    </td>
                  </tr>  
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                      <p> © Copyright ThemeTags.
                        <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;
                        from newsletter.
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>','type' => 'offline-payment-request','variables' => '[name], [email], [phone], [package],[price], [method],[note]','user_id' => '1','is_active' => '6','created_by_id' => NULL,'updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-02-03 14:08:34'),
          array('id' => '7','name' => 'Offline Payment Request Approve','subject' => 'Offline Payment Request Approve','slug' => 'offline-payment-request-approve','code' => '<div style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:0 auto; max-width: 600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                <tbody>
                  <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
    
                      <!--begin:Email content-->
                      <div style="text-align:center; margin:0 15px 34px 15px">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px"><img src="https://writerap.themetags.net/uploads/media/logo%20(1).png?v=1738591539" style="width: 162px;"><a href="https://writebot.themetags.com/" rel="noopener" target="_blank">
                          </a>
                        </div>
                        <!--end:Logo-->
    
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                          <img alt="Logo" src="https://writebot.themetags.com/public/images/like.svg" style="width: 120px; margin:40px auto;">
                        </div>
                        <!--end:Media-->
    
                        <!--begin:Text-->
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                          <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hi [name], <br>
                           Your request a offline payment has been approved [package] using this payment method <strong>[method]</strong> .</p>
                                                  
                            <p>Your  <strong>[package]</strong> price  <strong>[price]</strong> and start from [startDate]</p>
                            <p>Your [Package] Will be expire <strong>[endDate]</strong></p>
                         
                        </div>
                        <!--end:Text-->
    
                      </div>
                      <!--end:Email content-->
                    </td>
                  </tr> 
    
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                      <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ">
                        It’s all about customers!</p>
                      <p style="margin-bottom:2px">Call our customer care number: 540-907-0453</p>
                      <p style="margin-bottom:4px">You may reach us at <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600">admin@themetags.com</a>.
                      </p>
                      <p>We serve Mon-Fri, 9AM-18AM</p>
                    </td>
                  </tr>  
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                      <p> © Copyright ThemeTags.
                        <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;
                        from newsletter.
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>','type' => 'offline-payment-request-approve','variables' => '[name], [email], [phone], [package],[startDate], [endDate],[price], [method],[note]','user_id' => '1','is_active' => '7','created_by_id' => NULL,'updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-02-03 14:08:46'),
          array('id' => '8','name' => 'Offline Payment Request Reject','subject' => 'Offline Payment Request Reject','slug' => 'offline-payment-request-rejected','code' => '<div style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:0 auto; max-width: 600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                <tbody>
                  <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
    
                      <!--begin:Email content-->
                      <div style="text-align:center; margin:0 15px 34px 15px">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px"><img src="https://writerap.themetags.net/uploads/media/logo%20(1).png?v=1738591539" style="width: 162px;"><br></div>
                        <!--end:Logo-->
    
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                          <img alt="Logo" src="https://writebot.themetags.com/public/images/like.svg" style="width: 120px; margin:40px auto;">
                        </div>
                        <!--end:Media-->
    
                        <!--begin:Text-->
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                          <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hi [name], <br>
                           Your requested a offline payment for purchase <strong>[package]</strong> using this payment method <strong>[method]</strong> has been <strong>Rejected</strong> .</p>
                                        
    
                         
                        </div>
                        <!--end:Text-->
    
                      </div>
                      <!--end:Email content-->
                    </td>
                  </tr> 
    
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                      <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ">
                        It’s all about customers!</p>
                      <p style="margin-bottom:2px">Call our customer care number: 540-907-0453</p>
                      <p style="margin-bottom:4px">You may reach us at <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600">admin@themetags.com</a>.
                      </p>
                      <p>We serve Mon-Fri, 9AM-18AM</p>
                    </td>
                  </tr>  
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                      <p> © Copyright ThemeTags.
                        <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;
                        from newsletter.
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>','type' => 'offline-payment-request-rejected','variables' => '[name], [email], [phone], [package],[price], [method],[note]','user_id' => '1','is_active' => '8','created_by_id' => NULL,'updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-02-03 14:08:57'),
          array('id' => '9','name' => 'Offline Payment Request Add Note','subject' => 'Offline Payment Request Add Note','slug' => 'offline-payment-request-add-note','code' => '<div style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:0 auto; max-width: 600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                <tbody>
                  <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
    
                      <!--begin:Email content-->
                      <div style="text-align:center; margin:0 15px 34px 15px">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px"><img src="https://writerap.themetags.net/uploads/media/logo%20(1).png?v=1738591539" style="width: 162px;"><br></div>
                        <!--end:Logo-->
    
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                          <img alt="Logo" src="https://writebot.themetags.com/public/images/like.svg" style="width: 120px; margin:40px auto;">
                        </div>
                        <!--end:Media-->
    
                        <!--begin:Text-->
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                          <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hi [name], <br>
                           Your request a offline payment for purchase <strong>[package]</strong> using this payment method <strong>[method]</strong> .</p>
                            <p>But Admin Want more information from you</p>
                            <p>[note]</p>                         
    
                         
                        </div>
                        <!--end:Text-->
    
                      </div>
                      <!--end:Email content-->
                    </td>
                  </tr> 
    
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                      <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ">
                        It’s all about customers!</p>
                      <p style="margin-bottom:2px">Call our customer care number: 540-907-0453</p>
                      <p style="margin-bottom:4px">You may reach us at <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600">admin@themetags.com</a>.
                      </p>
                      <p>We serve Mon-Fri, 9AM-18AM</p>
                    </td>
                  </tr>  
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                      <p> © Copyright ThemeTags.
                        <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;
                        from newsletter.
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>','type' => 'offline-payment-request-add-note','variables' => '[name], [email], [phone], [package],[price], [method],[note]','user_id' => '1','is_active' => '9','created_by_id' => NULL,'updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-02-03 14:09:05'),
          array('id' => '10','name' => 'Assign Ticket','subject' => 'Assign Ticket5','slug' => 'ticket-assign','code' => '<div style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:0 auto; max-width: 600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                <tbody>
                  <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
    
                      <!--begin:Email content-->
                      <div style="text-align:center; margin:0 15px 34px 15px">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px"><img src="https://writerap.themetags.net/uploads/media/logo%20(1).png?v=1738591539" style="width: 162px;"><br></div>
                        <!--end:Logo-->
    
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                          <img alt="Logo" src="https://writebot.themetags.com/public/images/like.svg" style="width: 120px; margin:40px auto;">
                        </div>
                        <!--end:Media-->
    
                        <!--begin:Text-->
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                          <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hey, <br>
                            New Ticket from <strong>[name]</strong> and [ticketId] .</p>
                          
    
                         
                        </div>
                        <!--end:Text-->
    
                      </div>
                      <!--end:Email content-->
                    </td>
                  </tr> 
    
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                      <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ">
                        It’s all about customers!</p>
                      <p style="margin-bottom:2px">Call our customer care number: 540-907-0453</p>
                      <p style="margin-bottom:4px">You may reach us at <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600">admin@themetags.com</a>.
                      </p>
                      <p>We serve Mon-Fri, 9AM-18AM</p>
                    </td>
                  </tr>  
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                      <p> © Copyright ThemeTags.
                        <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;
                        from newsletter.
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>','type' => 'ticket-assign','variables' => '[name], [email], [phone], [title], [ticketId]','user_id' => '1','is_active' => '10','created_by_id' => NULL,'updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-02-03 14:09:12'),
          array('id' => '11','name' => 'Ticket Reply','subject' => 'Ticket Reply-5','slug' => 'ticket-reply','code' => '<div style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:0 auto; max-width: 600px;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                <tbody>
                  <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
    
                      <!--begin:Email content-->
                      <div style="text-align:center; margin:0 15px 34px 15px">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px"><img src="https://writerap.themetags.net/uploads/media/logo%20(1).png?v=1738591539" style="width: 162px;"><br></div>
                        <!--end:Logo-->
    
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                          <img alt="Logo" src="https://writebot.themetags.com/public/images/like.svg" style="width: 120px; margin:40px auto;">
                        </div>
                        <!--end:Media-->
    
                        <!--begin:Text-->
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                          <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hey, <br>
                            Ticket reply from  <strong>[name]</strong> and [ticketId] .</p>
                          
    
                         
                        </div>
                        <!--end:Text-->
    
                      </div>
                      <!--end:Email content-->
                    </td>
                  </tr> 
    
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                      <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ">
                        It’s all about customers!</p>
                      <p style="margin-bottom:2px">Call our customer care number: 540-907-0453</p>
                      <p style="margin-bottom:4px">You may reach us at <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600">admin@themetags.com</a>.
                      </p>
                      <p>We serve Mon-Fri, 9AM-18AM</p>
                    </td>
                  </tr>  
                  <tr>
                    <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                      <p> © Copyright ThemeTags.
                        <a href="https://writebot.themetags.com/" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;
                        from newsletter.
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>','type' => 'ticket-reply','variables' => '[name], [email], [phone], [title],[titleId]','user_id' => '1','is_active' => '0','created_by_id' => NULL,'updated_by_id' => '1','created_at' => NULL,'updated_at' => '2025-02-03 14:09:19')
      );

    DB::table('email_templates')->insert($email_templates);
  }
}
