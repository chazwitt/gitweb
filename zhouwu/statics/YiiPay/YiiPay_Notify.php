<?php
include_once("Config.php");

/*
 *====================================================================
 *					www.YiiPay.com
 *
 *                ��֧�� �ṩ����֧��
 *
 *     		��ҳ��Ϊ֧����ɺ��ȡ���صĲ���������......
 *
 *====================================================================
*/

//��ʼ���ղ��� (��ע�����ִ�Сд)
//-----------------------------------------------------------------
$tradeNo	=	isset($_REQUEST["tradeNo"])?$_REQUEST["tradeNo"]:"";	//֧�������׺�
$Money		=	isset($_REQUEST["Money"])?$_REQUEST["Money"]:0;			//������
$title		=	isset($_REQUEST["title"])?$_REQUEST["title"]:"";		//����˵����һ������վ�û���
$memo		=	isset($_REQUEST["memo"])?$_REQUEST["memo"]:"";			//��ע
$Sign		=	isset($_REQUEST["Sign"])?$_REQUEST["Sign"]:"";			//ǩ��
//-----------------------------------------------------------------		

if (strtoupper($Sign) != strtoupper(md5($WebID.$Key.$tradeNo.$Money.$title.$memo))){
		echo "Fail";	
		
		
	}else{

	//����MYSQL���ݿ�������Ϣ
		$mysql_server_name	=	"localhost"; 	//���ݿ����������
		$mysql_username		=	"vip"; 		// �������ݿ��û���
		$mysql_password		=	"xiaozeng885906";				// �������ݿ�����
		$mysql_database		=	"vip"; 			// ���ݿ������
		
		$mysql_conn = mysql_connect($mysql_server_name, $mysql_username, $mysql_password);
		if ($mysql_conn){
			mysql_select_db($mysql_database, $mysql_conn);
			
		 	/********************************************************************
			Ϊ�˷�ֹ�û��������˵�����򡰱�ע�����³�ֵʧ�ܣ��������ȼ���û����Ƿ���ڣ��پ����Զ��������Խ���������
			//$UserNameIsExist	=	true;	//�˴��޸�Ϊ���ļ�����,��Ȼ���������û�б�Ҫ��Ҳ���Բ����
			*/
			$rs=mysql_query("Select * From tp30_chongzhi Where num ='".$title."' and state=1");	//����ѯsql���Ľ���浽$rs������
			$num=mysql_num_rows($rs);											//mysql_num_rows���������þ��Ƿ��ؼ�¼����.����������ݱ��е��ܱ���
			if($num>0){
				$UserNameIsExist	=	true;	//���û�������
				$sql_u="Update  tp30_chongzhi  set state='4',addtime='".time()."',money='".$Money."'  Where  num='".$title."'";
				mysql_query($sql_u);
				//echo $sql_u;
				$rsu=mysql_fetch_array($rs);
				$userid=$rsu["uid"];
				
			}
			else{
				$UserNameIsExist	=	false;	//�û���������
			}
			//*******************************************************************
			
			if ($UserNameIsExist==true){		/*����û������ڣ����Զ�����*/
				/*
				 �˴���д���������ݿ⣨�Զ��������Ĵ���
				 
				**********�������ݿ�������ʼ*********************************************************
				/* �����û���� */
				mysql_query("Update tp30_member set money =money +".($Money)." Where id='$userid'");
				/* ���ӳ�ֵ��¼ */
				
				
				ob_clean();					//����֮ǰ�����
				echo "Success";				//�˴�����ֵ��Success�������޸ģ�����⵽���ַ���ʱ���ͱ�ʾ��ֵ�ɹ�
			 	/* **********�������ݿ���������********************************************************* */
			}else{
				echo "Order does not exist!";	//���û���������ʱ������ʾ����Ϣ�����Ҳ����Զ�����
			}
			//*******************************************************************
			mysql_close($mysql_conn);
		}else{
			echo "Conect failed";		//�������ݿ�ʧ��
		}
		//end========	
	}
?>
