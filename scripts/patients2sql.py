#!/usr/bin/env python
import sys
import re
from datetime import datetime, timedelta

dbcols = (
    ("stirpatientid", "patient_id", str, (20,)),
    ("age_admission", "age", int, None),
    ("type_of_acute_intervention", "intervention", str, (12,)),
    ("date_time_last_seen_normal", "lsn", datetime, None),
    ("triage_date_time", "triage", datetime, None),
    ("mri_date_time", "mri", datetime, None),
    ("iv_tpa_start_date_and_time", "treatment", datetime, None),
    (True, "lsn_triage", int, None),
    (True, "lsn_mri", int, None),
    (True, "lsn_treat", int, None),
    (True, "ethnic_origin", str, (20,)),
    (True, "hispanic_origin", str, (20,)),
    (True, "sex", str, (2,)),
    (True, "toast", str, (255,)),
    ("admit_nihss_total", "nihss_admit", int, None),
    ("2_hour_nihss_total", "nihss_2hour", int, None),
    ("discharge_nihss_total", "nihss_discharge", int, None),
    ("1_day_nihss_total", "nihss_1day", int, None),
    ("5_day_nihss_total", "nihss_5day", int, None),
    ("30_day_nihss_total", "nihss_30day", int, None),
    ("90_day_nihss_total", "nihss_90day", int, None),
    ("pre_admit_rankin_score", "rankin_preadmit", int, None),
    ("discharge_rankin_score", "rankin_discharge", int, None),
    ("1_day_rankin_score", "rankin_1day", int, None),
    ("5_day_rankin_score", "rankin_5day", int, None),
    ("30_day_rankin_score", "rankin_30day", int, None),
    ("90_day_rankin_score", "rankin_90day", int, None),
)

def mksql(pid, pdata):
    mapped = {}
    for col in dbcols:
        fromkey, tokey, totype, opts = col
        if fromkey == True:
            fromkey = tokey
        fromval = pdata[fromkey]
        if totype is int:
            try:
                toval = int(fromval)
            except:
                toval = None
        elif totype is str:
            maxlen, = opts
            toval = str(fromval)[0:maxlen]
        elif totype is datetime:
            try:
                toval = datetime.strptime(fromval, "%m/%d/%Y %H:%M")
            except:
                toval = None
        mapped[tokey] = toval
    cols = ", ".join(["%s" % (v,) for v in mapped.keys()])
    vals = []
    for v in mapped.values():
        if v is None:
            vals.append('null')
        else:
            vals.append("'%s'" % (v,))
    vals = ", ".join(vals)
    sql = "insert into patient (%s) values (%s);" % (cols, vals)
    return sql



if __name__ == "__main__":

    if len(sys.argv) < 3:
        print "include filenames"
        sys.exit(-1)

    tpafn = sys.argv[1]
    fn = sys.argv[2]

    def clnkey(k):
        p = re.compile(r'\W+')
        k = p.sub("_", k)
        return k.lower().strip("_").strip()

    tpaf = open(tpafn, "r")
    l = tpaf.readline().strip()
    tpah = [clnkey(f.strip().lower()) for f in l.split(",")]
    tpa = {}
    while l:
        l = l.strip().split(",")
        pid = l[0]
        d = dict(zip(tpah, l))
        tpa[pid] = d
        l = tpaf.readline()

    inf = open(fn, "r")
    l = inf.readline()
    ph = [clnkey(f.strip().lower()) for f in l.strip().split(",")]
    l = inf.readline()
    patients = {}
    i = 0

    while l:
        l = [f.strip("\"") for f in l.strip().split(",")]
        d = dict(zip(ph, l))
        if l[0] in tpa:
            d.update(tpa[l[0]])
            pk = l[0]

            lsndt = datetime.strptime(d["date_time_last_seen_normal"], "%m/%d/%Y %H:%M")
            lsn2mir = timedelta(minutes=int(d["exact_lsn_to_baseline_mri_time_minutes"]))

            d["mri_date_time"] = lsndt+lsn2mir
            mridt = d["mri_date_time"] #datetime.strptime(d["mri_date_time"], "%m/%d/%Y %H:%M")
            try:
                triagedt = datetime.strptime(d["triage_date_time"], "%m/%d/%Y %H:%M")
            except:
                triagedt = mridt

            treatdt =  datetime.strptime(d["iv_tpa_start_date_and_time"], "%m/%d/%Y %H:%M")

            d["lsn_triage"] = (triagedt - lsndt).total_seconds()/60
            d["lsn_mri"] = (mridt - lsndt).total_seconds()/60
            d["lsn_treat"] = (treatdt - lsndt).total_seconds()/60
            #print d["lsn_triage"], d["lsn_mri"], d["lsn_treat"]
            patients[pk] = d


        l = inf.readline()

    #print patients

    for pid,d in patients.items():
        #print pid, d
        print mksql(pid, d)
        #pass
