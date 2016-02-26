<spark-settings-subscription-screen inline-template>
	<div id="spark-settings-subscription-screen">
		<div v-if="userIsLoaded && plansAreLoaded">

			<!-- Current Coupon -->
			@include('spark::settings.tabs.subscription.coupon')

			<!-- Subscribe -->
			@include('spark::settings.tabs.subscription.subscribe')

			<!-- Update Subscription -->
			@include('spark::settings.tabs.subscription.change')

			<!-- Update Credit Card -->
			@include('spark::settings.tabs.subscription.card')

			<!-- Resume Subscription -->
			@include('spark::settings.tabs.subscription.resume')

			<!-- Invoices -->
			@if (count($invoices) > 0)
				@include('spark::settings.tabs.subscription.invoices.vat')

				@include('spark::settings.tabs.subscription.invoices.history')
			@endif

			<!-- Cancel Subscription -->
			@include('spark::settings.tabs.subscription.cancel')
		</div>

		<!-- Change Subscription Modal -->
		@include('spark::settings.tabs.subscription.modals.change')

		<!-- Cancel Subscription Modal -->
		@include('spark::settings.tabs.subscription.modals.cancel')
	</div>
</spark-settings-subscription-screen>
