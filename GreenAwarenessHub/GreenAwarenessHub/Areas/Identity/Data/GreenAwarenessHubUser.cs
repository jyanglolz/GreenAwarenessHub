using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using GreenAwarenessHub.Models;
using System.Data;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Identity;

namespace GreenAwarenessHub.Areas.Identity.Data;

// Add profile data for application users by adding properties to the GreenAwarenessHubUser class
public class GreenAwarenessHubUser : IdentityUser
{

    [PersonalData]
    public string ? FullName { get; set; }

    [ForeignKey("UserRole")]
    public int RoleID { get; set; }
    public UserRole User_Role { get; set; }


}

