<?php

namespace App\Filament\Pages;

use Filament\Pages\Actions\ButtonAction;
use Filament\Pages\Page;
use Filament\Forms;

class Settings extends Page
{


    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $view = 'filament.pages.settings';

    protected static ?string $navigationGroup = 'Settings';

    public function mount(): void
    {
        $this->form->fill([
            'company.name' => setting('company.name', ''),
            'company.phone' => setting('company.phone', ''),
            'company.email' => setting('company.email', ''),
            'company.website' => setting('company.website', ''),
            'company.fax' => setting('company.fax', ''),
            'company.address' => setting('company.address', ''),
            'company.city' => setting('company.city', ''),
            'company.state' => setting('company.state', ''),
            'company.postcode' => setting('company.postcode', ''),
            'company.country' => setting('company.country', ''),
            'company.employee_number_prefix' => setting('company.employee_number_prefix', ''),
            'company.currency' => setting('company.currency', ''),
            'company.site_name' => setting('company.site_name', ''),
        ]);
    }

    public function submit(): void
    {
        setting(['company.name' => $this->form->getState()['company']['name']]);
        setting(['company.phone' => $this->form->getState()['company']['phone']]);
        setting(['company.email' => $this->form->getState()['company']['email']]);
        setting(['company.website' => $this->form->getState()['company']['website']]);
        setting(['company.fax' => $this->form->getState()['company']['fax']]);
        setting(['company.address' => $this->form->getState()['company']['address']]);
        setting(['company.city' => $this->form->getState()['company']['city']]);
        setting(['company.state' => $this->form->getState()['company']['state']]);
        setting(['company.postcode' => $this->form->getState()['company']['postcode']]);
        setting(['company.country' => $this->form->getState()['company']['country']]);
        setting(['company.employee_number_prefix' => $this->form->getState()['company']['employee_number_prefix']]);
        setting(['company.currency' => $this->form->getState()['company']['currency']]);
        setting(['company.site_name' => $this->form->getState()['company']['site_name']]);
        setting()->save();
    }


    protected function getActions(): array
    {
        return [
            ButtonAction::make('settings')->action('openSettingsModal'),
        ];
    }

    public function openSettingsModal(): void
    {
        $this->dispatchBrowserEvent('open-settings-modal');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('Settings')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Company Details')
                        ->schema([
                            Forms\Components\TextInput::make('company.name')->required(),
                            Forms\Components\TextInput::make('company.phone')->required(),
                            Forms\Components\TextInput::make('company.email')->required(),
                            Forms\Components\TextInput::make('company.website')->required(),
                            Forms\Components\TextInput::make('company.fax')->required(),
                            Forms\Components\TextInput::make('company.address')->required(),
                            Forms\Components\TextInput::make('company.city')->required(),
                            Forms\Components\TextInput::make('company.state')->required(),
                            Forms\Components\TextInput::make('company.postcode')->required(),
                            Forms\Components\TextInput::make('company.country')->required(),
                        ]),
                    Forms\Components\Tabs\Tab::make('System')
                        ->schema([
                            Forms\Components\TextInput::make('company.employee_number_prefix')->required(),
                            Forms\Components\Select::make('company.currency')
                                ->options([
                                    'TZS' => 'TZS',
                                    'USD' => 'USD',
                                ])
                                ->required(),
                        ]),
                    Forms\Components\Tabs\Tab::make('Logo and Title')
                        ->schema([
                            Forms\Components\TextInput::make('company.site_name')->required(),
                        ]),
                ]),
        ];
    }
}
