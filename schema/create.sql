create sequence serial start 42;

create table patient(
	pat_key integer primary key not null default nextval('serial'),
	patient_id varchar(20),
	age integer,
	intervention varchar(12),
	lsn timestamp,
	triage timestamp,
	mri timestamp,
	treatment timestamp,
	lsn_triage integer,
	lsn_mri integer,
	lsn_treat integer,
	ethnic_origin varchar(20),
	hispanic_origin varchar(20),
	sex varchar(2),
	toast varchar(255),
	nihss_admit integer,
	nihss_2hour integer,
	nihss_discharge integer,
	nihss_1day integer,
	nihss_5day integer,
	nihss_30day integer,
	nihss_90day integer,
	rankin_preadmit integer,
	rankin_discharge integer,
	rankin_1day integer,
	rankin_5day integer,
	rankin_30day integer,
	rankin_90day integer
);

create table study (
	study_key integer primary key not null default nextval('serial'),
	study_id bigint,
	study_date timestamp,
	description varchar(255),
	pat_key integer  references patient(pat_key)

);

create table series (
	series_key integer primary key not null default nextval('serial'),
	series_id integer,
	study_key integer  references study(study_key),
	description varchar(255)
);

create table image (
	image_key integer primary key not null default nextval('serial'),
	image_num integer,
	image_path varchar(255),
	series_key integer  references series(series_key)
);