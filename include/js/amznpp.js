//
// $Id$
//
// Copyright 2014-2015 - Loudlever, Inc.
//
(function( amznpp, $, undefined ) {
  /*
  ---------------------------------------------
      PRIVATE PROPERTIES
  ---------------------------------------------
  */

  var WIDGET_CNT = 0;
  var WIDGET_SET = {};
  var AFFILIATES = {
    'com':    {domain: 'https://affiliate-program.amazon.com', id: 'amznpp-20'},
    'co.uk':  {domain: 'https://affiliate-program.amazon.co.uk', id: 'amznpp08-21'},
    'de':     {domain: 'https://partnernet.amazon.de', id: 'amznpp0d-21'},
    'fr':     {domain: 'https://partenaires.amazon.fr', id: 'amznpp06d-21'},
    'it':     {domain: 'https://programma-affiliazione.amazon.it', id: 'amznpp06d-21'},
    'es':     {domain: 'https://afiliados.amazon.es', id: 'amznpp0c8-21'},
    'ca':     {domain: 'https://associates.amazon.ca', id: 'amznpp0e-20'}
  };

  function getAffiliateId(region) {
    return AFFILIATES[region].id || AFFILIATES['com'].id;
  };

  function getAffiliateDomain(region) {
    return AFFILIATES[region].domain || AFFILIATES['com'].domain;
  };

  function updateAffiliateDomain() {
    var $sel = $('#amznpp_aff_cc').val();
    $('#amznpp_domain').attr('href',getAffiliateDomain($sel));
  };
  /*
  ---------------------------------------------
      PUBLIC FUNCTIONS
  ---------------------------------------------
  */
  amznpp.bind = function() {
    var $val = $(this).val();
    var $id = getAffiliateId($val);
    $('#amznpp_aff_id').val($id);
    updateAffiliateDomain();
  };

  amznpp.init = function() {
    $('#amznpp_aff_cc').change(amznpp.bind);
    // ensure all fields are set properly
    updateAffiliateDomain();
  };

}( window.amznpp = window.amznpp || {}, jQuery ));
jQuery( document ).ready( function( $ ) {
  amznpp.init();
});
