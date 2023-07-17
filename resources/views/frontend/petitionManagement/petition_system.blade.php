<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@extends('frontend.layouts.index')

@section('content')

@include('frontend.layouts.header')

<section class="breadcrumb_section">
  <div class="container">
      <div class="row align-items-center">
          <div class="col-sm-6">
              <div class="page-title">
                  <h3>পিটিশন আবেদন নিয়মাবলী</h3>
              </div>
          </div>
          <div class="col-sm-6">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-sm-end">
                  <li class="breadcrumb-item"><a href="#">হোম</a></li>
                  <li class="breadcrumb-item"><a href="#">পিটিশন</a></li>
                  <li class="breadcrumb-item active" aria-current="page">পিটিশন আবেদন নিয়মাবলী</li>
                </ol>
              </nav>
          </div>
      </div>
  </div>
</section>
    
<div class="container my-5">
  <div class="card p-5">
    <div class="card-title">
      <h2>Petition System</h2>
    </div>
    <hr/>

    <div class="card-body">
      <h3><strong>Scope of Petitions</strong></h3>
      <p>Petitions may be presented or submitted to the House with the consent of the Speaker on</p>
      <ol type="I">
      <li>A Bill which has been published under rule 76 or which has been introduced in the House;</li>
      <li>Any important matter connected with the business pending before the House; and</li>
      <li>Any other matter of public importance:<ol type="a">
      <li>Provided that no such matter shall be acceptable-</li>
      <li>which is subjudice before any court of law having jurisdiction in any part of Bangladesh or which is pending disposal by any statutory tribunal or authority discharging judicial or quasi-judicial functions or by any inquiry commission or inquiry court;</li>
      <li>which can be raised on a substantive motion or resolution; or</li>
      <li>for which remedy is available under the law, including rules, regulations, bye-laws made by the Government of Bangladesh or an authority to whom power to make such rules, regulations, etc. is delegated.</li>
      </ol></li>
      </ol>
      <h3>Petitions dealing with financial matters</h3>
      <p>A petition, dealing with any of the matters specified, in sub-clauses (a) to (e) of clause (1) of Article 81 of the Constitution or involving expenditure from the Consolidated Fund, shall not be presented to the House unless recommended by the President.</p>
      <h3>General form of petition</h3>
      <ol>
      <li>The general form of petition set out in Schedule II with such variations as the circumstance of each case require, may be used, and, if used, shall be sufficient.</li>
      <li>Every petition shall be couched in respectful, decorous and temperate language.</li>
      </ol>
      <h3>Authentication of petition</h3>
      <ol>
      <li>The full name and address of every signatory of a petition shall be set out therein and shall be authenticated by his signature, and if illiterate by his thumb-impression.</li>
      <li>Where there is more than one signatory to a petition at least one person shall sign, or, if illiterate, affix his thumb-impression, on the sheet on which the petition is inscribed. If signatures or thumb-impressions are affixed to more than one sheet, the prayer of the petition shall be repeated at the head of each sheet.</li>
      </ol>
      <h3>Documents not to be attached</h3>
      <p>Letters, affidavits or other documents shall not be attached to any petition.</p>
      <p>Counter-signature</p>
      <ol>
      <li>Every petition shall, if presented by a member, be countersigned by him.</li>
      <li>A member shall not present a petition from himself.</li>
      </ol>
      <h3>Petition to be addressed to House</h3>
      <p>Every petition shall be addressed to the House and shall conclude with a prayer reciting the definite object of the petitioner in regard to the matter to which it relates.</p>
      <h3>Notice of presentation</h3>
      <p>A member shall give advance intimation to the Secretary of his intention to present a petition.</p>
      <h3>Presentation of petition</h3>
      <p>A petition may be presented by a member or be forwarded to the Secretary, who shall report it to the House. No debate shall be permitted on the presentation, or the making of such report.</p>
      <h3>Form of presentation</h3>
      <p>A member presenting a petition shall confine himself to a statement in the following form:- "Sir, I beg to present a petition signed by....................petitioner(s) regarding ..............................." No debate shall be permitted on this statement.</p>
      <h3>Reference to Committee on petitions</h3>
      <p>Every petition shall, after presentation by a member or report by the Secretary, as the case may be, stand referred to the Committee on petition. [For rules relating to Committee on Petitions, see Chapter XXVII of these rules].</p>
      <h3>Constitution of Committee on Petitions</h3>
      <p>The Speaker shall nominate a Committee on petitions consisting of not less than ten members: Provided that a Minister shall not be nominated a member of the Committee, and that if a member, after his nomination to the Committee is appointed a Minister he shall cease to be a member of the Committee from the date of such appointment.</p>
      <h3>Functions of the Committee</h3>
      <ol>
      <li>The Committee shall examine every petition referred to it, and if the petition complies with these rules, the Committee may direct that it be circulated. Where circulation of the petition has not been directed, the Speaker may at any time direct that the petition be circulated.</li>
      <li>Circulation of the petition shall be in extenso or in summary form as the Committee or the Speaker, as the case may be, may direct.</li>
      <li>It shall also be the duty of the Committee to report to the House on specific complaints made in the petition referred to it and to suggest remedial measures in a concrete form.</li>
      </ol> 
    </div>
  </div>
</div>

<div class="divider"></div>
<!-- START FOOTER -->
@include('frontend.layouts.footer')

@endsection

@section('scripts')

@endsection
