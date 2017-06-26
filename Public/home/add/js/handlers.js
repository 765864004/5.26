/* Demo Note:  This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
The FileProgress class is not part of SWFUpload.
*/


/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */
var numu = 0;
function fileQueued(file) {
	try {
		numu += numFilesSelected;
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("上传队列中...");
		progress.toggleCancel(true, this);

	} catch (ex) {
		this.debug(ex);
	}

}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("上传太多文件啦.\n" + (message === 0 ? "达到上传个数限制啦." : "你只能选择 " + (message > 1 ? " " + message + " 个文件." : "一个文件.")));
			return;
		}

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			progress.setStatus("文件太大啦.");
			this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			progress.setStatus("不能上传0kb的文件.");
			this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			progress.setStatus("不支持的文件类型.");
			this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		default:
			if (file !== null) {
				progress.setStatus("未知错误.");
			}
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		/* I want auto start the upload and I can do that here */
		this.startUpload();
	} catch (ex)  {
        this.debug(ex);
	}
}

function uploadStart(file) {
	try {
		/* I don't want to do any file validation or anything,  I'll just update the UI and
		return true to indicate that the upload should start.
		It's important to update the UI here because in Linux no uploadProgress events are called. The best
		we can do is say we are uploading.
		 */
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("上传中...");
		progress.toggleCancel(true, this);
	}
	catch (ex) {}
	
	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		progress.setStatus("上传中...");
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		progress.setStatus("已上传.");
		progress.customCancel(true, swfu);
		//progress.toggleCancel(false);
		var json = JSON.parse(serverData);
		if(json.status == 1){
			input = document.createElement("input");
			input.id = progress.fileProgressID+"_input";
			input.type = "hidden";
			input.name = "imgfiles[]";
			input.value = json.name;
			//document.getElementById(progress.fileProgressID + "_img").src="http://images03.edeng.cn/uimages/6/imgtmp/" + json.name;
			document.getElementById(progress.fileProgressID + "_img").src="http://imgcdn.edeng.cn/temp/" + json.name;
			document.getElementById("eDeng").appendChild(input);
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadError(file, errorCode, message) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			progress.setStatus("上传错误: " + message);
			this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			progress.setStatus("上传失败.");
			this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			progress.setStatus("服务器 (IO) 错误.");
			this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			progress.setStatus("安全错误.");
			this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			progress.setStatus("上传限制.");
			this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			progress.setStatus("错误的验证.  上传取消.");
			this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			progress.setStatus("取消.");
			progress.setCancelled();
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			progress.setStatus("停止.");
			break;
		default:
			progress.setStatus("未知错误: " + errorCode);
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
	numu--;
}

// This event comes from the Queue Plugin
function queueComplete(numFilesUploaded) {
	//document.getElementById("eDeng").submit();
}

function CheckImageAndFiles() {
	do {
		if (!CheckFields()) {
			return false;
		}
		CheckVerify(CheckImage);
	} while (false);
}

function CheckImage(){
	if (numu > 0) {
		alert("请等在图片上传完成再发布");
		return false;
	}
	document.getElementById("eDeng").submit();
	postpop.dialog();
	return true;
}

function CheckVerify(callBack){
	var XMLHttp = false;
	if (window.XMLHttpRequest) {
		XMLHttp = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		try {
			XMLHttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				XMLHttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
			}
		}
	}
	if(!XMLHttp){
		return false;
	}
	var vrify = document.getElementById("number").value;
	XMLHttp.open('post', '/code/bin/post/verify.php', true);
	XMLHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	XMLHttp.send(parseContent({"verify":vrify}));
	XMLHttp.onreadystatechange = function() {
		if (XMLHttp.readyState == 4) {
			if (XMLHttp.status == 200 || XMLHttp.status == 0) {				
				var reps = typeof JSON == 'undefined' ? eval("("+XMLHttp.responseText+")") : JSON.parse(XMLHttp.responseText);				
				if(reps.status == 1){
					if(callBack && typeof callBack == 'function'){
						callBack();
					}
				}else{
					alert("验证码错误，请重新填写！");
					document.getElementById("verifyCode").click();
				}
			}else{
				alert("网络错误，请重试！");
			}
		}
	};
}

function parseContent (o){
	if (typeof (o) == 'object') {
		var str = '';
		for (a in o) {
			str += a + '=' + o[a] + '&';
		}
		str = str.substr(0, str.length - 1);
		return str;
	} else {
		return o;
	}
}
