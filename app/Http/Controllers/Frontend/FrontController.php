<?php
/**
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
 */
namespace App\Http\Controllers\Frontend;

use App;
use App\Http\Controllers\Controller;
use App\Model\Frontend\AboutSection;
use App\Model\Frontend\LatestNews;
use App\Model\Frontend\MobileApp;
use App\Model\Frontend\MpMessage;
use App\Model\Frontend\NewsTicker;
use App\Model\Frontend\NoticeVerticalMenu;
use App\Model\Frontend\NumberCounter;
use App\Model\Frontend\Slider;
use App\Model\Frontend\VideoGallery;
use App\Model\Frontend\CitizenQuestion;
use App\Model\Frontend\ProjectCarousel;
use App\Model\Frontend\ProjectCategory;
use App\Model\Frontend\BottomSection;
use App\Model\Parliament;
use App\Model\V2Profile;

class FrontController extends Controller {

    public function __construct() {

    }

    public function index() {
        $data['parliament']  = Parliament::where( 'status', 1 )->first();
        $data['profileData'] = V2Profile::where( 'user_id', '>', 0 )
            ->where( 'v2_profiles.parliamentNumber', $data['parliament']->parliament_number )
            ->where( 'constituencies.parliamentNumber', $data['parliament']->parliament_number )
            ->leftJoin( 'constituencies', 'v2_profiles.constituencyNumber', '=', 'constituencies.number' )
            ->select( 'v2_profiles.nameBng as nameBng', 'v2_profiles.nameEng as nameEng', 'v2_profiles.user_id as userId', 'constituencies.bn_name as voterAreaBng', 'constituencies.name as voterAreaEng', 'constituencies.number as bangladeshNumber' )
            ->get();

        $data['newsTitles']     = NewsTicker::where( 'status', 1 )->orderBy( 'id', 'desc' )->limit( 10 )->get();
        $data['sliders']        = Slider::where( 'status', 1 )->orderBy( 'id', 'desc' )->limit( 5 )->get();
        $data['mpMessages']     = MpMessage::where( 'status', 1 )->orderBy( 'id', 'desc' )->get();
        $data['numberCounters'] = NumberCounter::where( 'status', 1 )->orderBy( 'id', 'desc' )->get();
        $data['videoGalleries'] = VideoGallery::where( 'status', 1 )->orderBy( 'id', 'desc' )->get();
        $data['latestVideo']    = VideoGallery::where( 'status', 1 )->orderBy( 'id', 'desc' )->first();
        $data['mobileApp']      = MobileApp::where( 'status', 1 )->orderBy( 'id', 'desc' )->first();
        $data['latestNews']     = LatestNews::where( 'status', 1 )->orderBy( 'id', 'desc' )->limit( 9 )->get();
        $data['verticalMenus']  = NoticeVerticalMenu::where( 'status', 1 )->orderBy( 'id', 'desc' )->get();
        $data['aboutSection']   = AboutSection::where( 'status', 1 )->orderBy( 'id', 'desc' )->first();

        // Citizen Question
        $data['getMaxQuestion'] = CitizenQuestion::select( 'v2_profiles.nameBng as nameBng', 'v2_profiles.nameEng as nameEng', 'v2_profiles.photo as photo', 'citizen_questions.id as questionId', 'citizen_questions.citizenName as citizenName', 'citizen_questions.citizenQuestion as citizenQuestion', 'citizen_questions.mpAnswer as mpAnswer' )
        ->selectRaw('count(citizen_questions.mp_id) AS `count`')
        ->leftJoin( 'v2_profiles', 'v2_profiles.user_id', '=', 'citizen_questions.mp_id' )
        ->groupBy('citizen_questions.mp_id')
        ->orderBy('count','DESC')
        ->limit(3)
        ->get();
        $data['getMaxAnswer'] = CitizenQuestion::where( 'mpAnswer', '!=', '' )
        ->select( 'v2_profiles.nameBng as nameBng', 'v2_profiles.nameEng as nameEng', 'v2_profiles.photo as photo', 'citizen_questions.id as questionId', 'citizen_questions.citizenName as citizenName', 'citizen_questions.citizenQuestion as citizenQuestion', 'citizen_questions.mpAnswer as mpAnswer' )
        ->selectRaw('count(citizen_questions.mp_id) AS `count`')
        ->leftJoin( 'v2_profiles', 'v2_profiles.user_id', '=', 'citizen_questions.mp_id' )
        ->groupBy('citizen_questions.mp_id')
        ->orderBy('count','DESC')
        ->limit(3)
        ->get();
        // End Citizen Question

        $data['projectCategories'] = ProjectCategory::where( 'status', 1 )->orderBy( 'id', 'asc' )->get();
        $data['projectCarousel']   = ProjectCarousel::where( 'status', 1 )->orderBy( 'id', 'desc' )->get();

        return view( 'frontend.home', $data );
    }

}
