[{include file="headitem.tpl" title="Tiramizoo"}]

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

[{cycle assign="_clear_" values=",2" }]
 
<h2>[{ oxmultilang ident="oxTiramizoo_settings_title" }] <span style="font-size: 9px;">version [{$version}]</span></h2>

<style type="text/css">
  .editinput {width:240px;}

  ul li {background: transparent;}
  .delete_date {color: #888;}
</style>





<link rel="stylesheet" type="text/css" href="/modules/oxtiramizoo/src/yui/build/calendar/assets/skins/sam/calendar.css">
 
<!-- Dependencies -->
<script src="/modules/oxtiramizoo/src/yui/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script src="/modules/oxtiramizoo/src/yui/build/event-delegate/event-delegate.js"></script>
<!-- Source file -->
<script src="/modules/oxtiramizoo/src/yui/build/calendar/calendar-min.js"></script>

<div id=liste>
  
    <form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
    <input type="hidden" name="fnc" value="save">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="editval[oxshops__oxid]" value="[{$oxid}]">

    [{if $aErrors|@count gt 0}]
    <div class="errorbox">
      [{ oxmultilang ident="oxTiramizoo_enable_fix_errors_header" }]:
      <ol>
      [{foreach from=$aErrors item=sError}]
        <li>[{$sError}]</li>
      [{/foreach}]
      </ol>
    </div>
    [{/if}]


    <table cellspacing="0" cellpadding="0" border="0" style="width:100%;height:100%;">
      <tr>
        <td valign="top" class="edittext" style="padding:10px;">
         <table cellspacing="0" cellpadding="5" border="0" class="edittext" style="text-align: left;">
            




<tr>
  <td colspan="2"><h3>Api connection settings</h3></td>
</tr>  


            <tr>
              <td valign="top" class="edittext" nowrap="">[{ oxmultilang ident="oxTiramizoo_settings_api_url_label" }]</td>
              <td valign="top" class="edittext">
                <input type=text class="editinput" name=confstrs[oxTiramizoo_api_url] value="[{$confstrs.oxTiramizoo_api_url}]" maxlength="100" />
                [{ oxinputhelp ident="oxTiramizoo_settings_api_url_help" }]
              </td>
            </tr>

            <tr>
              <td valign="top" class="edittext" nowrap="">[{ oxmultilang ident="oxTiramizoo_settings_shop_url_label" }]</td>
              <td valign="top" class="edittext">
                <input type=text class="editinput" name=confstrs[oxTiramizoo_shop_url] value="[{$confstrs.oxTiramizoo_shop_url}]" maxlength="100" />
                [{ oxinputhelp ident="oxTiramizoo_settings_shop_url_help" }]
              </td>
            </tr>









<tr>
  <td colspan="2"><h3>Packing strategy</h3></td>
</tr>  

            <tr>
              <td valign="top" class="edittext" nowrap="">Define Package size</td>
              <td valign="top" class="edittext" id="selectPackageStrategyRadiosCell">
                <input class="selectPackageStrategyRadios" type="radio" name=confnum[oxTiramizoo_package_strategy] [{if ($confnum.oxTiramizoo_package_strategy == 0)}]checked="checked"[{/if}] value="0" /> [{ oxmultilang ident="oxTiramizoo_settings_package_sizes_strategy_1_label" }]<br />
                <input class="selectPackageStrategyRadios" type="radio" name=confnum[oxTiramizoo_package_strategy] [{if ($confnum.oxTiramizoo_package_strategy == 1)}]checked="checked"[{/if}] value="1" /> [{ oxmultilang ident="oxTiramizoo_settings_package_sizes_strategy_2_label" }] (specified from tiramizoo dashboard) <br />
                <input class="selectPackageStrategyRadios" type="radio" name=confnum[oxTiramizoo_package_strategy] [{if ($confnum.oxTiramizoo_package_strategy == 2)}]checked="checked"[{/if}] value="2" /> [{ oxmultilang ident="oxTiramizoo_settings_package_sizes_strategy_3_label" }]<br />
              </td>
            </tr>

            <script type="text/javascript">
            (function() {
                var Dom = YAHOO.util.Dom,
                    Event = YAHOO.util.Event;

                var initPackage = function() {

                    var selectPackageStrategyRadios = YAHOO.util.Dom.getElementsByClassName('selectPackageStrategyRadios');
                    Event.addListener(selectPackageStrategyRadios, 'click', selectPackageStrategy);
                }

                var selectPackageStrategy = function() {
                  var input = YAHOO.util.Dom.getElementsBy(function (el) {
                                  return (el.name === 'confnum[oxTiramizoo_package_strategy]' && el.checked);
                              }, 'input', 'selectPackageStrategyRadiosCell', null, null, null, true);

                  var packageStrategyId = input.value;

                  var oxTiramizoo_package_strategy_rows = YAHOO.util.Dom.getElementsByClassName('oxTiramizoo_package_strategy_row');
                  YAHOO.util.Dom.setStyle(oxTiramizoo_package_strategy_rows, 'display', 'none');

                  var oxTiramizoo_package_strategy_rows_to_show = YAHOO.util.Dom.getElementsByClassName('oxTiramizoo_package_strategy_' + packageStrategyId);
                  YAHOO.util.Dom.setStyle(oxTiramizoo_package_strategy_rows_to_show, 'display', 'table-row');

                }

                Event.addListener(window, 'load', initPackage);

            })();
            </script>


            <tr class="oxTiramizoo_package_strategy_row oxTiramizoo_package_strategy_2" [{if ($confnum.oxTiramizoo_package_strategy != 2)}]style="display:none;"[{/if}]>
              <td valign="top" class="edittext" nowrap="">[{oxmultilang ident="oxTiramizoo_settings_package_std_size_weight_label"}]</td>
              <td valign="top" class="edittext">

                [{oxmultilang ident="oxTiramizoo_settings_dimensions_short_width_label"}]: <input type=text class="editinput" name="confstrs[oxTiramizoo_std_package_width]" value="[{$confstrs.oxTiramizoo_std_package_width}]" maxlength="10" style="width:40px;" /> [{ oxmultilang ident="oxTiramizoo_settings_dimensions_unit" }]
                
                [{oxmultilang ident="oxTiramizoo_settings_dimensions_short_length_label"}]: <input type=text class="editinput" name="confstrs[oxTiramizoo_std_package_length]" value="[{$confstrs.oxTiramizoo_std_package_length}]" maxlength="10" style="width:40px;" /> [{ oxmultilang ident="oxTiramizoo_settings_dimensions_unit" }]

                [{oxmultilang ident="oxTiramizoo_settings_dimensions_short_height_label"}]: <input type=text class="editinput" name="confstrs[oxTiramizoo_std_package_height]" value="[{$confstrs.oxTiramizoo_std_package_height}]" maxlength="10" style="width:40px;" /> [{ oxmultilang ident="oxTiramizoo_settings_dimensions_unit" }]

                [{oxmultilang ident="oxTiramizoo_settings_dimensions_short_weight_label"}]: <input type=text class="editinput" name="confstrs[oxTiramizoo_std_package_weight]" value="[{$confstrs.oxTiramizoo_std_package_weight}]" maxlength="10" style="width:40px;" /> [{ oxmultilang ident="oxTiramizoo_settings_weight_unit" }]

                [{ oxinputhelp ident="oxTiramizoo_settings_package_std_size_weight_help" }]

              </td>
            </tr>


<tr>
  <td colspan="2"><h3>Default dimensions and weight</h3></td>
</tr>  


          <tr>
            <td class="edittext">
              [{ oxmultilang ident="oxTiramizoo_settings_weight_label" }]
            </td>
            <td class="edittext">
              <input type="text" class="editinput" size="10" maxlength="10" style="width:40px;" name="confstrs[oxTiramizoo_global_weight]" value="[{$confstrs.oxTiramizoo_global_weight}]">[{ oxmultilang ident="oxTiramizoo_category_tab_weight_unit" }] 
              [{ oxinputhelp ident="oxTiramizoo_settings_weight_help" }]
            </td>
          </tr>

          <tr>
            <td class="edittext">
              [{ oxmultilang ident="oxTiramizoo_settings_dimensions_label" }]
            </td>
            <td class="edittext">
              L:&nbsp;<input type="text" class="editinput" size="3" maxlength="10" style="width:40px;" name="confstrs[oxTiramizoo_global_length]" value="[{$confstrs.oxTiramizoo_global_length}]">[{ oxmultilang ident="oxTiramizoo_category_tab_dimensions_unit" }]
              W:&nbsp;<input type="text" class="editinput" size="3" maxlength="" style="width:40px;" name="confstrs[oxTiramizoo_global_width]" value="[{$confstrs.oxTiramizoo_global_width}]">[{ oxmultilang ident="oxTiramizoo_category_tab_dimensions_unit" }]
              H:&nbsp;<input type="text" class="editinput" size="3" maxlength="" style="width:40px;" name="confstrs[oxTiramizoo_global_height]" value="[{$confstrs.oxTiramizoo_global_height}]">[{ oxmultilang ident="oxTiramizoo_category_tab_dimensions_unit" }]

              [{ oxinputhelp ident="oxTiramizoo_settings_dimensions_help" }]
            </td>
          </tr>


<tr>
  <td colspan="2"><h3>Available payment methods</h3></td>
</tr>  




            <tr>
              <td>[{ oxmultilang ident="oxTiramizoo_settings_payment_methods_assigned_label" }]</td>
              <td>
                <ul>
                  [{foreach from=$oPaymentsList key=sPaymentId item=aPayment}]
                     <li style="background:transparent;">
                        <input type="hidden" name="payment[[{$sPaymentId}]]" value="0" />
                        <input type="checkbox" name="payment[[{$sPaymentId}]]" value="1" [{if ($aPayment.checked)}]checked="checked"[{/if}] />
                        [{$aPayment.desc}]
                     </li>
                  [{/foreach}]                
                </ul>
              </td>
            </tr>


<tr>
  <td colspan="2"><h3>Enabling shipping method</h3></td>
</tr>  

            <tr>
              <td valign="top" class="edittext" nowrap="">[{ oxmultilang ident="oxTiramizoo_settings_articles_with_stock_gt_0" }]</td>
              <td valign="top" class="edittext">
                <input type="hidden"  name="confbools[oxTiramizoo_articles_stock_gt_0]" value"0" />
                <input type="checkbox" name="confbools[oxTiramizoo_articles_stock_gt_0]" value"1" [{ if $confbools.oxTiramizoo_articles_stock_gt_0}]checked="checked"[{ /if }]> 
                [{ oxinputhelp ident="oxTiramizoo_settings_articles_with_stock_gt_0_help" }]
              </td>
            </tr>

            <tr>
              <td valign="top" class="edittext" width="250" nowrap="">          
                <input type="submit" name="save" value="[{ oxmultilang ident="oxTiramizoo_settings_save_label" }]" [{ $readonly}]>
              </td>
            </tr>

          </table>

        </td>
      </tr>
    </table>
    </form>






    <h3>Retail locations</h3>

    <table cellspacing="0" cellpadding="0" border="0" style="width:100%;height:100%;">
      <tr>
        <td valign="top" class="edittext" style="padding:10px;">


        <form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
        [{$oViewConf->getHiddenSid()}]
          <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
          <input type="hidden" name="fnc" value="addNewLocation">
          <input type="hidden" name="oxid" value="[{$oxid}]">
          <input type="hidden" name="editval[oxshops__oxid]" value="[{$oxid}]">

            <table cellspacing="0" cellpadding="5" border="0" class="edittext" style="text-align: left;">
                
                <tr>
                  <td colspan="2"><h3>New API token</h3></td>
                </tr>  

                <tr>
                  <td valign="top" class="edittext" nowrap="">API token</td>
                  <td valign="top" class="edittext">
                    <input type=text class="editinput" name="api_token" maxlength="100" />
                    [{ oxinputhelp ident="oxTiramizoo_settings_api_url_help" }]
                  </td>
                </tr>

            </table>   
            <input type="submit" value="Add new retail location" />
        </form>


        </td>
      </tr>

      <tr>
        <td valign="top" class="edittext" style="padding:10px;">
         <table cellspacing="0" cellpadding="5" border="0" class="edittext" style="text-align: left;">
            
            <tr>
              <td colspan="2"><h3>Retail locations</h3></td>
            </tr>  

          [{if $aRetailLocations|@count}]
              [{foreach from=$aRetailLocations item=oRetaiLocation}]
              <tr>
                  <td coslpan="2"> 

                      <form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
                          [{$oViewConf->getHiddenSid()}]

                          [{$oRetaiLocation->getConfVar('account_name')}] [{ $oRetaiLocation->getApiToken() }]  

<!--                           <br /><br />
                          [{$oRetaiLocation->getConfVar('postal_codes')|@print_r}]<br />
                          [{$oRetaiLocation->getConfVar('time_windows')|@print_r}]<br />
 -->


                          <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
                          <input type="hidden" name="fnc" value="removeLocation">
                          <input type="hidden" name="api_token" value="[{$oRetaiLocation->getApiToken()}]">
                          <input type="hidden" name="oxid" value="[{$oxid}]">
                          <input type="hidden" name="editval[oxshops__oxid]" value="[{$oxid}]">
                          <input type="submit" value="detach this api" />

                          <a target="_top" href="[{$oRetaiLocation->getConfVar('dashboard_url')}]">Go to dashboard</a>
                          
                      </form>



                  </td>
              </tr>
              [{/foreach}]
          [{else}]
              <tr>
                  <td>
                      There is no API tokens yet            
                  </td>
              </tr>  
          [{/if}]



        </table>      
          </td>
        </tr>
  </table>        





    <h3>Synchronize all configuration</h3>

  
    <form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
      [{$oViewConf->getHiddenSid()}]
      <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
      <input type="hidden" name="fnc" value="synchronize">
      <input type="hidden" name="oxid" value="[{$oxid}]">
      <input type="hidden" name="editval[oxshops__oxid]" value="[{$oxid}]">
      <input type="submit" value="Synchronize" />
    </form>






  [{include file="pagenavisnippet.tpl"}]
</div>
[{include file="pagetabsnippet.tpl"}]

[{include file="bottomnaviitem.tpl"}]

[{include file="bottomitem.tpl"}]
