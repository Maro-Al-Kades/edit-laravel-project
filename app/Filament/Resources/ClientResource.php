<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $modelLabel = 'عميل';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $pluralModelLabel = 'العملاء';

    protected static ?string $navigationLabel = 'العملاء';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('البريد الالكتروني')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable(),
                TextColumn::make('n_shares')
                    ->label('عدد الأسهم')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('area.name')
                    ->label('المنطقة')
                    ->searchable(),
                TextColumn::make('city.name')
                    ->label('المدينة')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('الموظف')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'طلب جديد' => 'gray',
                        'تحت المتابعة' => 'warning',
                        'غير مهتم' => 'danger',
                        'إنشاء عقد' => 'info',
                        'تم التعاقد' => 'success',
                        'ملغي' => 'danger',
                        'عميل متمم' => 'danger',
                    }),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->hasRole('موظف')) {
                    return $query->where('user_id', auth()->id());
                }
            })
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('واتساب')
                    // ->button()
                        ->icon('heroicon-m-chat-bubble-oval-left-ellipsis')
                        ->iconPosition(IconPosition::After)
                        ->modalHeading('إرسال رسالة واتساب للعميل')
                        ->fillForm(fn (Client $record): array => [
                            'phone' => $record->phone,
                        ])
                        ->form([
                            TextInput::make('phone')
                                ->label('رقم الهاتف')
                                ->readonly(),
                            Textarea::make('msg')
                                ->label('الرسالة'),
                        ])
                        ->action(function (array $data, Client $record): void {
                            $url = "https://api.whatsapp.com/send?phone={$data['phone']}&text={$data['msg']}";
                            redirect()->away($url);
                        }),
                    Action::make('الحالة')
                        ->label('الحالة')
                    // ->button()
                        ->icon('heroicon-m-viewfinder-circle')
                        ->iconPosition(IconPosition::After)
                        ->modalHeading('تغيير حالة العميل')
                        ->fillForm(fn (Client $record): array => [
                            'status' => $record->status,
                        ])
                        ->form([
                            Select::make('status')
                                ->label('الحالة')
                                ->options([
                                    'طلب جديد' => 'طلب جديد',
                                    'تحت المتابعة' => 'تحت المتابعة',
                                    'غير مهتم' => 'غير مهتم',
                                    'إنشاء عقد' => 'إنشاء عقد',
                                    'تم التعاقد' => 'تم التعاقد',
                                    'ملغي' => 'ملغي',
                                    'عميل متمم' => 'عميل متمم',
                                ]),
                        ])
                        ->action(function (array $data, Client $record): void {
                            $record->status = $data['status'];
                            $record->save();
                        }),
                    Action::make('view')
                        ->label('معلومات إضافية')
                    // ->button()
                        ->icon('heroicon-m-viewfinder-circle')
                        ->iconPosition(IconPosition::After)
                        ->infolist([
                            Section::make()
                                ->columns([
                                    'sm' => 1,
                                    'xl' => 2,
                                    '2xl' => 2,
                                ])
                                ->schema([
                                    TextEntry::make('name')->label('الإسم'),
                                    TextEntry::make('phone')->label('الهاتف'),
                                    TextEntry::make('fullname')->label('الإسم الرباعي'),
                                    TextEntry::make('n_shares')->label('عدد الأسهم'),
                                    TextEntry::make('area.name')->label('المنطقة'),
                                    TextEntry::make('city.name')->label('المدينة'),
                                    TextEntry::make('identity')->label('رقم الهوية'),
                                    TextEntry::make('iban')->label('الإيبان'),
                                    TextEntry::make('bank')->label('البنك'),
                                    TextEntry::make('profession')->label('المهنة'),
                                    TextEntry::make('birth')->label('تاريخ الميلاد'),
                                    TextEntry::make('status')->label('الحالة')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
                                            'طلب جديد' => 'gray',
                                            'تحت المتابعة' => 'warning',
                                            'غير مهتم' => 'danger',
                                            'إنشاء عقد' => 'info',
                                            'تم التعاقد' => 'success',
                                            'ملغي' => 'danger',
                                            'عميل متمم' => 'danger',
                                        }),
                                ]),
                        ])->modalSubmitAction(false),
                    Action::make('الموظف المسؤول')
                        ->label('الموظف المسؤول')
                    // ->button()
                        ->icon('heroicon-m-viewfinder-circle')
                        ->iconPosition(IconPosition::After)
                        ->modalHeading('ربط العميل بالموظف المسؤول')
                        ->form([
                            Select::make('user_id')
                                ->label('الموظف')
                                ->relationship(name: 'user', titleAttribute: 'name'),
                        ])
                        ->fillForm(fn (Client $record): array => [
                            'user_id' => $record->user_id,
                        ])
                        ->action(function (array $data, Client $record): void {
                            $record->user_id = $data['user_id'];
                            $record->save();
                        })
                        ->hidden(fn ($record) => ! auth()->user()->hasRole('مدير')),
                ])
                    ->iconButton(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
