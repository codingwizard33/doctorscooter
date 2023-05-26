<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->string('email', 191);
			$table->integer('currency_id')->nullable()->index('currency_id');
			$table->string('CompanyName');
			$table->string('CompanyPhone');
			$table->string('CompanyAdress');
			$table->string('logo', 191)->nullable();

            $table->string('app_name')->default('POS');
            $table->string('app_address')->nullable();
            $table->string('app_phone')->nullable();
            $table->string('app_https')->nullable();
            $table->string('app_url');
            $table->string('app_date_format')->default('L');
            $table->string('app_date_locale')->default('en');
            $table->string('app_default_role')->default('2');
            $table->string('app_background')->nullable();
            $table->string('app_icon')->nullable();
            $table->string('app_locale')->default('en');
            $table->string('app_timezone')->default('UTC');
            $table->boolean('app_user_registration')->default(false);
            //outgoing email
            $table->string('queue_connection')->default('sync');
            $table->string('mail_from_name')->default('POS');
            $table->string('mail_from_address')->nullable();
            $table->string('mail_mailer')->default('log');
            $table->string('mail_host')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_port')->default('2525');
            $table->string('mail_encryption')->nullable()->default('tls');
            $table->string('mailgun_domain')->nullable();
            $table->string('mailgun_endpoint')->nullable();
            $table->string('mailgun_secret')->nullable();
            //recaptcha
            $table->boolean('recaptcha_enabled')->default(false);
            $table->string('recaptcha_public')->nullable();
            $table->string('recaptcha_private')->nullable();
            //currency
            $table->string('currency_symbol')->default('$');
            $table->boolean('currency_symbol_on_left')->default(true);
            //tax
            $table->float('tax_rate')->default(0);
            $table->boolean('is_tax_fix')->default(false);
            $table->boolean('is_tax_included')->default(false);
            $table->string('tax_id')->nullable();
            //terms
            $table->longText('repair_invoice_terms')->nullable();
            $table->longText('bill_invoice_terms')->nullable();
            $table->longText('sale_invoice_terms')->nullable();
            $table->longText('custom_buy_invoice_terms')->nullable();
            //print setup
            $table->string('print_font_family')->default('monospace');
            $table->string('print_font_size')->default('11');
            $table->string('print_font_color')->default('black');
            $table->string('print_printer_width')->default('210mm');
            $table->string('print_printer_height')->default('297mm');
            $table->string('print_qr_code_size')->default('100');
            //POS setup
            $table->string('pos_monies')->default('100,500,1000,5000');
            $table->boolean('pos_scanner_focus_autofocus')->default(1);
            $table->string('pos_scanner_focus_duration')->default(500);
            $table->string('pos_scanner_processing_delay')->default(700);
            $table->string('default_warehouse_id')->default(1);

			$table->timestamps(6);
			$table->softDeletes();
		});

}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
	}

}
