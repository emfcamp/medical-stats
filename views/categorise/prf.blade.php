@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-10">
    	<h2 class="mt-0 mb-3">Seen by: {{ $discharge->getSeenBy() }}
        @if ($discharge->getRefused === true)
          <span class="refused"> (Refused Treatment)</span>
        @endif
      </h2>
    </div>
    <div class="col-md-2">
      <p class="text-right"><strong>{{ $completed + 1 }} / {{ $total }}</strong></p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-3">
      <h4>Primary Survey</h4>
      <p>{{ $primary->getPresenting() }}</p>
      <p class="tight">Response: <strong>{{ $primary->getResponse() }}</strong></p>
      <p class="tight">Airway: <strong>{{ $primary->getAirway() }}</strong></p>
      <p class="tight">Breathing: <strong>{{ $primary->getBreathing() }}</strong></p>
      <p class="tight">Circulation: <strong>{{ $primary->getCirculation() }}</strong></p>
      <p class="tight">@include('partials.checkicon', ['icon' => $primary->getCapacity(), 'positive' => "yes"]) Capacity</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $primary->getConsent(), 'positive' => "yes"]) Consent</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $primary->getExternalBleeding(), 'positive' => "no"]) External Bleeding</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $primary->getConsciousnessLoss(), 'positive' => "no"]) Loss of Consciousness</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $primary->getAlcoholDrugsSuspected(), 'positive' => "no"]) Alcohol or Drugs Suspected</p>
    </div>
    <div class="col-md-3">
      <h4>Secondary Survey</h4>

      @unless ($secondary->getAllergies() == "null")
      <p class="tight">Allergies: <strong>{{ $secondary->getAllergies() }}</strong></p>
      @endunless
      @unless ($secondary->getMedications() == "null")
      <p class="tight">Medications: <strong>{{ $secondary->getMedications() }}</strong></p>
      @endunless
      @unless ($secondary->getMedicalHistory() == "null")
      <p class="tight">Medical History: <strong>{{ $secondary->getMedicalHistory() }}</strong></p>
      @endunless
      @unless ($secondary->getComplaintHistory() == "null")
      <p class="tight">Complaint History: <strong>{{ $secondary->getComplaintHistory() }}</strong></p>
      @endunless

      <p class="tight">@include('partials.checkicon', ['icon' => $secondary->getHighBloodPressure(), 'positive' => "no"]) High Blood Pressure</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $secondary->getStroke(), 'positive' => "no"]) Stroke</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $secondary->getSeizures(), 'positive' => "no"]) Seizures</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $secondary->getDiabetes(), 'positive' => "no"]) Diabetes</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $secondary->getCardiac(), 'positive' => "no"]) Cardiac</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $secondary->getAsthma(), 'positive' => "no"]) Asthma</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $secondary->getRespiratory(), 'positive' => "no"]) Respiratory</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $secondary->getFast(), 'positive' => "no"]) FAST (stroke symptoms)</p>
    </div>
    <div class="col-md-3">
      <h4>Treatment</h4>
      <p class="tight">@include('partials.checkicon', ['icon' => $treatment->getAirwayOpened(), 'positive' => "no"]) Airway Opened</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $treatment->getWoundCleaned(), 'positive' => "no"]) Wound Cleaned</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $treatment->getWoundDressed(), 'positive' => "no"]) Wound Dressed</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $treatment->getRice(), 'positive' => "no"]) Rest, Ice, Compression, Elevation</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $treatment->getAdhesiveDressing(), 'positive' => "no"]) Adhesive Dressing</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $treatment->getSling(), 'positive' => "no"]) Sling</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $treatment->getSplint(), 'positive' => "no"]) Splint</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $treatment->getRecoveryPosition(), 'positive' => "no"]) Recovery Position</p>

      <p class="tight">Other: <strong>{{ $treatment->getOther() }}</strong></p>
    </div>
    <div class="col-md-3">
      <h4>Discharge</h4>

      <p class="tight">@include('partials.checkicon', ['icon' => $discharge->getWalkingAided(), 'positive' => "no"]) Walking Aided</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $discharge->getWalkingUnaided(), 'positive' => "yes"]) Walking Unaided</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $discharge->getOwnTransport(), 'positive' => "no"]) Own Transport</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $discharge->getPublicTransport(), 'positive' => "no"]) Public Transport</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $discharge->getAmbulance(), 'positive' => "no"]) Ambulance</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $discharge->getTaxi(), 'positive' => "no"]) Taxi</p>
      <p>Other transport: <strong>{{ $discharge->getOtherTransport() }}</strong></p>

      <p class="tight">@include('partials.checkicon', ['icon' => $discharge->getTreatmentCompleted(), 'positive' => "yes"]) Treatment Completed</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $discharge->getAdvisedFurther(), 'positive' => "no"]) Advised Further Medical</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $discharge->getHospital(), 'positive' => "no"]) Hospital</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $discharge->getReviewLater(), 'positive' => "no"]) Review Later</p>
      <p class="tight">Receiving centre: <strong>{{ $discharge->getReceivingCentre() }}</strong></p>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-3">
      <h4>Serious</h4>

      <p class="tight">@include('partials.checkicon', ['icon' => $serious->getAmbulance(), 'positive' => "no"]) Ambulance Called</p>
      @if ($serious->getAmbulance() === true)
        <p class="tight">On site: {{ $serious->getAmbulanceArrived()->toTimeString() }} - {{ $serious->getAmbulanceDeparted()->toTimeString() }}</p>
      @endif
      <p class="tight">@include('partials.checkicon', ['icon' => $serious->getCpr(), 'positive' => "no"]) CPR</p>
      <p class="tight">@include('partials.checkicon', ['icon' => $serious->getDefib(), 'positive' => "no"]) Defib</p>
    </div>
    <div class="col-md-6">
      <h3>Categorise</h3>
    	<form id="prf" action="categorise.php" method="POST">
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="form-group row">
          <label for="category" class="col-sm-2 col-form-label">Category</label>
          <div class="col-sm-10">
            <select class="form-control" id="category" name="category">
              <option value="-">Select...</option>
              @foreach ($categories as $category)
                <option value="{{ $category }}">{{ $category }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row d-none">
          <label for="severity" class="col-sm-2 col-form-label">Severity</label>
          <div class="col-sm-10">
            <select class="form-control" id="severity" name="severity">
              <option value="-">Select...</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="riddor" class="col-sm-2 col-form-label">RIDDOR?</label>
          <div class="col-sm-10">
            <select class="form-control" id="riddor" name="riddor">
              <option value="false">No</option>
              <option value="true">Yes</option>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary" name="save">Save</button>
      </form>
    </div>
  </div>


  <script>
    var categoryLookup = @json($categoryLookup);
  </script>
@endsection