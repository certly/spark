<?php

namespace Laravel\Spark\Ux\Settings;

use Laravel\Spark\Spark;

class DashboardTabs extends Tabs
{
    /**
     * Get the tab configuration for the "profile" tab.
     *
     * @return \Laravel\Spark\Ux\Settings\Tab
     */
    public function profile()
    {
        return new Tab('Profile', 'spark::settings.tabs.profile', 'fa-user');
    }

    /**
     * Get the tab configuration for the "teams" tab.
     *
     * @return \Laravel\Spark\Ux\Settings\Tab
     */
    public function teams()
    {
        return new Tab('Teams', 'spark::settings.tabs.teams', 'fa-users', function () {
            return Spark::usingTeams();
        });
    }

    /**
     * Get the tab configuration for the "security" tab.
     *
     * @return \Laravel\Spark\Ux\Settings\Tab
     */
    public function security()
    {
        return new Tab('Security', 'spark::settings.tabs.security', 'fa-lock');
    }

    /**
     * Get the tab configuration for the "subscription" tab.
     *
     * @param  bool  $force
     * @return \Laravel\Spark\Ux\Settings\Tab|null
     */
    public function subscription($force = false)
    {
        return new Tab('Subscription', 'spark::settings.tabs.subscription', 'fa-credit-card', function () use ($force) {
            return count(Spark::plans()->paid()) > 0 || $force;
        });
    }
}
