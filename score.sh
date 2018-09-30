SCRIPT_HOME='Scripts'                          # Hold Python scripts
GRAND_DATAFRAME_NA='DataframeGrandProNuc.pvar' # Hold Derived info from Pdb
Prediction_DIR='DL_output'        # Hold reformat pickled deep learning grid results
RNA_Pdb_Database_DIR='Pdb'   # Hold Source RNA conformer pdb
RNA_Mer_Database_DIR='Mer'   # Hold Analysed Mer for RNA pdb
Docking_Target_Pdb_DIR='Apo' # Hold Target Apo protein 
Pharm_Output_DIR='Out'       # Hold Clique analysis result
ICP_Output_DIR='Icp'         # Hold Pdb produce from ICP
BC_DIR='bc-100.out'          # Hold External redundancy record
PDB_Depository='/media/jhmlam/CAESAR/MessLab/Database-PDB/unzipped/'
BGSU_DIR='/media/jhmlam/CAESAR/MessLab/Database-Nucleic3Dstructure/BGSU'
Pyle_DIR='/media/jhmlam/CAESAR/MessLab/Database-Nucleic3Dstructure/PyleRNAlibraries'
KnownSite_DIR='Control'
RNAC_DIR='/home/jhmlam/MessLab/Project-NucleicBind/protein_RNA_interaction_package/RNACompete_data/'
Working_DIR='GridData'
conda activate /opt/conda/envs/py3
python ${SCRIPT_HOME}/Nucleic-Bind_HMM_ScoreSomeSequences.py --PredictionFolder ${Prediction_DIR} --TestSequences $1 --Targetname ${Docking_Target_Pdb_DIR}