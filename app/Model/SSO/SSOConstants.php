<?php

namespace App\Model\SSO;

class SSOConstants
{

    /* 
        appId=E2WO10AALMIbQX8kB8Lms8QtZFbx8nNU
        appName=SSO Testing
        sharedSecret=LDNkbCkeNmdk7ID2n3GRpbjfe14IJ71KExEtlCmW7OCTONP8F14EkgJDPYjsTae6cVeAytcSjN0UCEL1EpZQqs0AEu2Bp2jJSnKUqKkwHv7ZGUjSStaObNAqyeAIvrrvv730pOMUcjAVq6BUEVj7tGGo0w1gL98llfDJzkomPqgbNEcJpR7TRqW7dZhVIG3iIPEtYPjiUDhZn16yVCvTQl1Eq2kdcHF7ynUOXMJxTIceCrMpfLd2GW2wJVdCWwBl
        idpurl=https://103.156.52.135/prp_sso/
        etintervalms=180000
        apploginendpoint=applogin
        ialoginendpoint=interapplogin
        appNameQS=appName

        redirectUri=http://localhost:8888/idp_slave/
        landingPageUri=http://localhost:8888/idp_slave/
        loginpageuri=http://localhost:8888/idp_slave/
    */


    const APP_ID = "wa5FoYHaHxROSKDNSz2cSdBvQPbsu0M9"; //"qLLXu3XBllnR90OWKzUm3NnnYLthGUMb";
    const APP_NAME = "SSO Testing";
    const SHARED_SECRET = "9YANV2uyLIEPRUJOmJv2uGW0dNiLmP8yE3J7k8WoigieRitFrzMESTBPAC7ura8s2KjtOhNJyZmrI0E0nQ2zOyH6Ys487hdoU0yvjwraWvKyc298fuDDPWdUMwAtLwPdadoZefinPiYUSPk9gPBN8KyDJrqYoW7xjT2JGM498kcdBJqLgOFGWwIhsWz6e1JhZrTmdCZTujYkRWZVMKZkfR3llOcMAf0K2ifEH7BNIbZz9XdRk3Dnsa8URaCi6Vel"; //"bTEWXWO3orST9NVJuZjyQhe7Zumq1riigPnkBGtjfHcUSaH3qRBcm9qA3ZPMDCQp0Ueybso1siKnzOKkzN6X1kJ0cBU6eEgj3B7kvJaw60kqMAwIzvRZ5ZBKSUGWXS2ltaBDsWgQXegqhHgr1NfRgjQm8hOMDL9l9iQtyNzdL3dyqa5YfuacPDnAOF08KCAMlxPF922aQINcOFvdzuS2rS2y18hAMAatbUkwCesi3O3I3EUcN0HBwvQKyNdrUz27";
    const IDP_URL = "https://prp.parliament.gov.bd/prp_sso"; //"http://account.beta.doptor.gov.bd";
    
    const APP_NAME_QS = "appName";
    const APP_ID_QS = "appId";
    const APP_LOGIN_ENDPOINT = "api/applogin";
    const IA_LOGIN_ENDPOINT = "interapplogin";
    const AUTHORIZE_END_POINT = "authorize";
    const SLO_END_POINT = "ssologout";
    const TOKEN_EXP_DATE = "180000";

    const REDIRECT_URI = "http://nanoit.biz/project/mp_portal_test/dashboard";
    const LANDING_PAGE_URI = "http://nanoit.biz/project/mp_portal_test/dashboard";
    const LOGIN_PAGE_URI = "http://nanoit.biz/project/mp_portal_test"; // base url

    const USERNAME = "0110011";
    const EMPLOYEE_RECORD_ID = "employee_record_id";
    const OFFICE_ID = "office_id";
    const DESIGNATION = "designation";
    const OFFICE_UNIT_ID = "office_unit_id";
    const INCHARGE_LABEL = "incharge_label";
    const OFFICE_UNIT_ORGANOGRAM_ID = "office_unit_organogram_id";
    const OFFICE_NAME_ENG = "office_name_eng";
    const OFFICE_NAME_BNG = "office_name_bng";
    const OFFICE_MINISTRY_ID = "office_ministry_id";
    const OFFICE_MINISTRY_NAME_ENG = "office_ministry_name_eng";
    const OFFICE_MINISTRY_NAME_BNG = "office_ministry_name_bng";
    const UNIT_NAME_ENG = "unit_name_eng";
    const UNIT_NAME_BNG = "unit_name_bng";
    const FROM_APP_NAME = "fromAppName";
    const FROM_APP_ID = "fromAppId";
    const TO_APP_NAME = "toAppName";
    const TO_APP_ID = "toAppId";
    const LANDING_PAGE_URL = "landingpageurl";
    const TOKEN_EXP_TIME_TEXT = "expirationTime";
}
