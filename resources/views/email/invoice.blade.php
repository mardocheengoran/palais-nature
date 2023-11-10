<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <meta charset="utf-8" />
        <meta name="x-apple-disable-message-reformatting" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="format-detection" content="telephone=no, date=no, address=no, email=no" />
        <!--[if mso]>
            <xml>
                <o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings>
            </xml>
            <style>
                td,
                th,
                div,
                p,
                a,
                h1,
                h2,
                h3,
                h4,
                h5,
                h6 {

                    font-family: "Segoe UI", sans-serif;
                    mso-line-height-rule: exactly;
                }
            </style>
        <![endif]-->
        <title>Commande</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700" rel="stylesheet" media="screen" />
        <style>
            .hover-underline:hover {
                text-decoration: underline !important;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            @keyframes ping {
                75%,
                100% {
                    transform: scale(2);
                    opacity: 0;
                }
            }

            @keyframes pulse {
                50% {
                    opacity: 0.5;
                }
            }

            @keyframes bounce {
                0%,
                100% {
                    transform: translateY(-25%);
                    animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
                }

                50% {
                    transform: none;
                    animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
                }
            }

            @media (max-width: 600px) {
                .sm-px-24 {
                    padding-left: 24px !important;
                    padding-right: 24px !important;
                }

                .sm-py-32 {
                    padding-top: 32px !important;
                    padding-bottom: 32px !important;
                }

                .sm-w-full {
                    width: 100% !important;
                }
            }
        </style>
    </head>

    <body style="margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased; --bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity)); font-family: 'Montserrat', Arial, sans-serif;">
        <div>
            @if ($type == 'administrateur')
                <h1 style="text-align: center"> Recapitulatif de la commande {{ $invoice->code }} </h1><br>
            @else
                <h1 style="text-align: center">Votre commande {{ $invoice->code }}</h1><br>
            @endif
        </div>
        <div role="article" aria-roledescription="email" aria-label="Reset your Password" lang="en">
            <table style="font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td align="center"
                        style="--bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity)); font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;"
                        bgcolor="rgba(236, 239, 241, var(--bg-opacity))">
                        <table class="sm-w-full" style="font-family: 'Montserrat', Arial, sans-serif; width: 600px;" width="600" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td class="sm-py-32 sm-px-24" style="font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; padding: 48px; text-align: center;" align="center">
                                    <a href="{{ route('welcome') }}">
                                        <img src="{{ asset('img/logo.png') }}" width="155" alt="{{ $setting->title }}" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle;" />
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" class="sm-px-24" style="font-family: 'Montserrat', Arial, sans-serif;">
                                    <table style="font-family: 'Montserrat', Arial, sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                        <tr>
                                            <td
                                                class="sm-px-24"
                                                style="
                                                    --bg-opacity: 1;
                                                    background-color: #ffffff;
                                                    background-color: rgba(255, 255, 255, var(--bg-opacity));
                                                    border-radius: 4px;
                                                    font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;
                                                    font-size: 14px;
                                                    line-height: 24px;
                                                    padding: 20px;
                                                    text-align: left;
                                                    --text-opacity: 1;
                                                    color: #626262;
                                                    color: rgba(98, 98, 98, var(--text-opacity));
                                                " bgcolor="rgba(255, 255, 255, var(--bg-opacity))" align="left">
                                                <p style="font-weight: 600; font-size: 18px; margin-bottom: 0;">
                                                    Bonjour {{ $type == 'fournisseur' ? 'fournisseur' : '' }},
                                                </p>

                                                @if ($type == 'administrateur' or $type == 'fournisseur')
                                                    <div style="text-align: center;">
                                                        Nouvelle commande sur <a href="{{ route('welcome') }}">{{ $setting->title }}</a> du client {{ $invoice->customer->first_name.' '.$invoice->customer->name }} du {{ $invoice->created_at->formatLocalized('%A %d %B %Y à %H:%M') }}
                                                        @if($invoice->commercial_id)
                                                            Passé par le commercial {{ $invoice->commercial->first_name.' '.$invoice->commercial->name }}
                                                        @endif
                                                    </div>
                                                    @if ($type == 'administrateur')
                                                        <div style="border: 1px solid #ccc; margin-top: 20px; text-align: center; width: 100%;">
                                                            <div style="font-size: 16px; font-weight: 900;">Infos client</div>
                                                            <table class="table" style="width: 100%;">
                                                                <tr>
                                                                    <td>
                                                                        {{ $invoice->customer->first_name.' '.$invoice->customer->name }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $invoice->customer->email }}
                                                                    </td>
                                                                    <td>
                                                                        @isset($invoice->address->subtitle) {{ $invoice->address->subtitle }} @endisset
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if ($invoice->commercial_id)
                                                        <div>Cher commercial {{ $invoice->commercial->first_name.' '.$invoice->commercial->name }},</div>
                                                        <div>Nous vous remercions de votre commande pour votre client "{{ $invoice->customer->first_name.' '.$invoice->customer->name }}" sur <a href="{{ route('welcome') }}">{{ $setting->title }} !</a></div>
                                                        <div>La commande {{ $invoice->code }} a été confirmée avec succès.</div>
                                                        <div>Elle sera emballée et expédiée dès que possible. Votre client recevra une notification de notre part dès que les produits seront prêts à être livrés.</div>
                                                    @else
                                                        <div>Cher {{ $invoice->customer->first_name.' '.$invoice->customer->name }},</div>
                                                        <div>Nous vous remercions pour votre commande sur <a href="{{ route('welcome') }}">{{ $setting->title }}! </a></div>
                                                        <div>Votre commande {{ $invoice->code }} a été confirmée avec succès.</div>
                                                        <div>Elle sera emballée et expédiée dès que possible. Vous recevrez une notification de notre part dès que les produits seront prêts à être livrés.</div>
                                                    @endif
                                                @endif

                                                <table style="font-family: 'Montserrat', Arial, sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tr>
                                                        <td style="font-family: 'Montserrat', Arial, sans-serif; font-size: 14px; padding: 16px;">
                                                            <table style="font-family: 'Montserrat', Arial, sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                                <tr>
                                                                    <td style="font-family: 'Montserrat', Arial, sans-serif; font-size: 14px;">
                                                                        Total commande :
                                                                        <strong>{{ devise($invoice->price_final) }}</strong>
                                                                    </td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td style="font-family: 'Montserrat', Arial, sans-serif; font-size: 14px;">
                                                                        Date de livraison prévue :
                                                                        <strong>{{ $invoice->planned_at->formatLocalized('%A %d %B %Y') }}</strong>
                                                                    </td>
                                                                </tr> --}}
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table style="font-family: 'Montserrat', Arial, sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tr>
                                                        <td style="font-family: 'Montserrat', Arial, sans-serif;">
                                                            <h3 style="font-weight: 700; font-size: 12px; margin-top: 0; text-align: left;">
                                                                #{{ $invoice->code }}
                                                            </h3>
                                                        </td>
                                                        <td style="font-family: 'Montserrat', Arial, sans-serif;">
                                                            <h3 style="font-weight: 700; font-size: 12px; margin-top: 0; text-align: right;">
                                                                Passée {{ Carbon\Carbon::now()->formatLocalized('%A %d %B %Y à %H:%M') }}
                                                            </h3>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="font-family: 'Montserrat', Arial, sans-serif;">
                                                            <table style="font-family: 'Montserrat', Arial, sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                                <tr>
                                                                    <th align="left" style="padding-bottom: 8px; width: 40%;" width="40%">
                                                                        <p>Article</p>
                                                                    </th>
                                                                    <th align="left" style="padding-bottom: 8px; width: 20%;" width="20%">
                                                                        <p>Prix unitaire</p>
                                                                    </th>
                                                                    <th align="left" style="padding-bottom: 8px; width: 20%;" width="20%">
                                                                        Quantité
                                                                    </th>
                                                                    <th align="left" style="padding-bottom: 8px; width: 20%;" width="20%">
                                                                        Total
                                                                    </th>
                                                                </tr>
                                                                @foreach ($invoice->articles as $item)
                                                                    <tr style="font-family: 'Montserrat', Arial, sans-serif; font-size: 14px;">
                                                                        <td style="padding-top: 10px; padding-bottom: 10px; width: 40%;" width="40%">
                                                                            <a href="{{ route('article.show', $item->slug) }}">
                                                                                @if(!empty($item->getMedia('image')->first()))
                                                                                    <img style="margin-right:10px;float: left; width: 80px;" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->title }}">
                                                                                @endif
                                                                                {{ $item->title }}
                                                                            </a>
                                                                        </td>
                                                                        <td style="width: 20%;" width="20%">
                                                                            {{ devise($item->pivot->price) }}
                                                                        </td>
                                                                        <td style="width: 20%;" width="20%">
                                                                            {{ $item->pivot->quantity }}
                                                                        </td>
                                                                        <td style="width: 20%;" width="20%">
                                                                            {{ devise($item->pivot->price * $item->pivot->quantity) }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <td colspan="3" style="font-family: 'Montserrat', Arial, sans-serif; width: 80%;" width="80%">
                                                                        <p align="right" style="font-weight: 700; font-size: 14px; line-height: 24px; margin: 0; padding-right: 16px; text-align: right;">
                                                                            Sous total
                                                                        </p>
                                                                    </td>
                                                                    <td style="font-family: 'Montserrat', Arial, sans-serif; width: 20%;" width="20%">
                                                                        <p align="right" style="font-weight: 700; font-size: 14px; line-height: 24px; margin: 0; text-align: right;">
                                                                            {{ devise($invoice->price_ht) }}
                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="3" style="font-family: 'Montserrat', Arial, sans-serif; width: 80%;" width="80%">
                                                                        <p align="right" style="font-weight: 700; font-size: 14px; line-height: 24px; margin: 0; padding-right: 16px; text-align: right;">
                                                                            Frais de livraison
                                                                        </p>
                                                                    </td>
                                                                    <td style="font-family: 'Montserrat', Arial, sans-serif; width: 20%;" width="20%">
                                                                        <p align="right" style="font-weight: 700; font-size: 14px; line-height: 24px; margin: 0; text-align: right;">
                                                                            {{ devise($invoice->price_delivery) }}
                                                                        </p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="3" style="font-family: 'Montserrat', Arial, sans-serif; width: 80%;" width="80%">
                                                                        <p align="right" style="font-weight: 700; font-size: 14px; line-height: 24px; margin: 0; padding-right: 16px; text-align: right;">
                                                                            Total
                                                                        </p>
                                                                    </td>
                                                                    <td style="font-family: 'Montserrat', Arial, sans-serif; width: 20%;" width="20%">
                                                                        <p align="right" style="font-weight: 700; font-size: 14px; line-height: 24px; margin: 0; text-align: right;">
                                                                            {{ devise($invoice->price_final) }}
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table align="center" style="font-family: 'Montserrat', Arial, sans-serif; margin-left: auto; margin-right: auto; text-align: center; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tr>
                                                        <td align="right" style="font-family: 'Montserrat', Arial, sans-serif;">
                                                            <table style="font-family: 'Montserrat', Arial, sans-serif; margin-top: 24px; margin-bottom: 24px;" cellpadding="0" cellspacing="0" role="presentation">
                                                                <tr>
                                                                    <td
                                                                        align="right"
                                                                        style="
                                                                            mso-padding-alt: 16px 24px;
                                                                            --bg-opacity: 1;
                                                                            background-color: #ee7f11;
                                                                            border-radius: 4px;
                                                                            font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;
                                                                        "
                                                                        bgcolor="rgba(115, 103, 240, var(--bg-opacity))">
                                                                        <a
                                                                            href="{{ route('profile.show') }}"
                                                                            style="display: block; font-weight: 600; font-size: 14px; line-height: 100%; padding: 16px 24px; --text-opacity: 1; color: #ffffff; color: rgba(255, 255, 255, var(--text-opacity)); text-decoration: none;">
                                                                            En savoir plus &rarr;
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <p style="font-size: 14px; line-height: 24px; margin-top: 6px; margin-bottom: 20px;">
                                                    Si vous avez des questions sur cette facture, répondez simplement à cet e-mail ou contactez notre
                                                    <a href="{{ route('contact') }}">équipe d'assistance</a> pour obtenir de l'aide.
                                                </p>
                                                <p style="text-align: right; margin-top: 30px; font-weight: 700; font-size: 18px; margin-top: 0;">
                                                    L'équipe {{ $setting->title }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family: 'Montserrat', Arial, sans-serif; height: 20px;" height="20"></td>
                                        </tr>
                                        <tr>
                                            <td
                                                style="
                                                    font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;
                                                    font-size: 12px;
                                                    padding-left: 48px;
                                                    padding-right: 48px;
                                                    --text-opacity: 1;
                                                    color: #eceff1;
                                                    color: rgba(236, 239, 241, var(--text-opacity));
                                                ">
                                                {{-- <p align="center" style="cursor: default; margin-bottom: 16px;">
                                                    <a href="https://www.facebook.com/pixinvents" style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity)); text-decoration: none;">
                                                        <img src="images/facebook.png" width="17" alt="Facebook" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle; margin-right: 12px;" />
                                                    </a>
                                                    &bull;
                                                    <a href="https://twitter.com/pixinvents" style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity)); text-decoration: none;">
                                                        <img src="images/twitter.png" width="17" alt="Twitter" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle; margin-right: 12px;" />
                                                    </a>
                                                    &bull;
                                                    <a href="https://www.instagram.com/pixinvents" style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity)); text-decoration: none;">
                                                        <img src="images/instagram.png" width="17" alt="Instagram" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle; margin-right: 12px;" />
                                                    </a>
                                                </p> --}}
                                                {{-- <p style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity));">
                                                    Use of our service and website is subject to our
                                                    <a href="https://pixinvent.com/" class="hover-underline" style="--text-opacity: 1; color: #ee7f11; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">Terms of Use</a>
                                                    and
                                                    <a href="https://pixinvent.com/" class="hover-underline" style="--text-opacity: 1; color: #ee7f11; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">
                                                        Privacy Policy
                                                    </a>
                                                    .
                                                </p> --}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family: 'Montserrat', Arial, sans-serif; height: 16px;" height="16"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
