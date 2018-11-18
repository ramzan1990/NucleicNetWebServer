
#=============================================================

# Downstream II: Analyse Deep learning output from NucleicNet 

#=============================================================

#__author__ = "Jordy Homing Lam"
#__copyright__ = "Copyright 2018, Hong Kong University of Science and Technology"
#__license__ = "3-clause BSD"


SCRIPT_HOME='Scripts'                          # Hold Python scripts
GRAND_DATAFRAME_NA='DataframeGrandProNuc.pvar' # Hold Derived info from Pdb
Prediction_DIR=$1/DL_output        # Hold reformat pickled deep learning grid results
RNA_Pdb_Database_DIR='Pdb'   # Hold Source RNA conformer pdb
RNA_Mer_Database_DIR='Mer'   # Hold Analysed Mer for RNA pdb
Docking_Target_Pdb_DIR='Apo' # Hold Target Apo protein 
Pharm_Output_DIR=$1/Out       # Hold Clique analysis result
ICP_Output_DIR='Icp'         # Hold Pdb produce from ICP
BC_DIR='bc-100.out'          # Hold External redundancy record

PDB_Depository='/media/jhmlam/CAESAR/MessLab/Database-PDB/unzipped/'
BGSU_DIR='/media/jhmlam/CAESAR/MessLab/Database-Nucleic3Dstructure/BGSU'
Pyle_DIR='/media/jhmlam/CAESAR/MessLab/Database-Nucleic3Dstructure/PyleRNAlibraries'
KnownSite_DIR='Control'
#RNAC_DIR='/home/jhmlam/MessLab/Project-NucleicBind/protein_RNA_interaction_package/entiredata_2018_08_27_5-05_am/'
RNAC_DIR='/home/jhmlam/MessLab/Project-NucleicBind/protein_RNA_interaction_package/RNACompete_data/'

Working_DIR=$1/Out


source activate py3

# 1. Read and Prune Result Grids
# TODO Bootstrap increase the precision of grid prediction however what is the point 
# of bootstrapping other then selecting over the percentile of predicted probability score??? 
# What if we just choose a percentile out of the probability calculated from DL?
for i in $1/GridData/*.pdb 
do
j=$(echo ${i} | sed 's/GridData\///g' | sed 's/.pdb//g')
echo j
echo "---------------------------------------------"
echo ${Pharm_Output_DIR}
python ${SCRIPT_HOME}/Nucleic-Bind_RigidDock_StrongGrid.py \
	--RNAMerFolder ${RNA_Mer_Database_DIR} --TargetPdbFolder ${Docking_Target_Pdb_DIR} \
	--PredictionFolder ${Prediction_DIR} --OutputFolder ${Pharm_Output_DIR} \
	--Tolerance 3.00 --MaxDistance 30.0 --Pdbid ${j}
done
date

# 2. Process the files into Visualisable forms
for i in $1/GridData/*.pdb
do
j=$(echo ${i} | sed 's/GridData\///g' | sed 's/.pdb//g')
echo j
echo "---------------------------------------------"
echo ${Pharm_Output_DIR}
python ${SCRIPT_HOME}/Nucleic-Bind_VisualisationProcessing.py --Pdbid ${j} --OutputFolder ${Pharm_Output_DIR} --ApoFolder ${Working_DIR}
done
date


# ====================
# For Argonaute only
# ====================




